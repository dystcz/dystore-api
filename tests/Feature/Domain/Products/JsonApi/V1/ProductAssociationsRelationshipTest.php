<?php

use Dystore\Api\Domain\Prices\Models\Price;
use Dystore\Api\Domain\ProductAssociations\Models\ProductAssociation;
use Dystore\Api\Domain\Products\Models\Product;
use Dystore\Api\Domain\ProductVariants\Factories\ProductVariantFactory;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can list product associations through relationship', function () {
    /** @var TestCase $this */

    /** @var Product $productA */
    $productA = Product::factory()->create();

    /** @var Product $productB */
    $productB = Product::factory()
        ->has(ProductVariantFactory::new()->has(Price::factory()), 'variants')
        ->create();

    $productA->associate(
        $productB,
        ProductAssociation::UP_SELL
    );

    $response = $this
        ->jsonApi()
        ->expects('product_associations')
        ->get(serverUrl("/products/{$productA->getRouteKey()}/product_associations"));

    $response
        ->assertSuccessful()
        ->assertFetchedMany($productA->associations)
        ->assertDoesntHaveIncluded();
})->group('products');

it('can count product associations', function () {
    /** @var TestCase $this */

    /** @var Product $productA */
    $productA = Product::factory()->create();

    /** @var Product $productB */
    $productB = Product::factory()
        ->has(ProductVariantFactory::new()->has(Price::factory()), 'variants')
        ->create();

    $productA->associate(
        $productB,
        ProductAssociation::UP_SELL
    );

    $response = $this
        ->jsonApi()
        ->expects('products')
        ->get(serverUrl("/products/{$productA->getRouteKey()}?with_count=product_associations"));

    $response
        ->assertSuccessful()
        ->assertFetchedOne($productA);

    expect($response->json('data.relationships.product_associations.meta.count'))->toBe(1);
})->group('products', 'counts');
