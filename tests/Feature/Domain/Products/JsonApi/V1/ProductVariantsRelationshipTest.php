<?php

use Dystore\Api\Domain\Prices\Models\Price;
use Dystore\Api\Domain\Products\Factories\ProductFactory;
use Dystore\Api\Domain\Products\Models\Product;
use Dystore\Api\Domain\ProductVariants\Factories\ProductVariantFactory;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariant;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can list product variants through relationship', function () {
    /** @var TestCase $this */

    /** @var Product $product */
    $product = ProductFactory::new()
        ->has(ProductVariantFactory::new()->count(3), 'variants')
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('product_variants')
        ->get(serverUrl("/products/{$product->getRouteKey()}/product_variants"));

    $response
        ->assertSuccessful()
        ->assertFetchedMany($product->variants)
        ->assertDoesntHaveIncluded();
})->group('products');

it('can count product variants', function () {
    /** @var TestCase $this */
    $product = Product::factory()
        ->has(
            ProductVariant::factory()->has(Price::factory())->count(5),
            'variants'
        )
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('products')
        ->get(serverUrl("/products/{$product->getRouteKey()}?with_count=product_variants"));

    $response
        ->assertSuccessful()
        ->assertFetchedOne($product);

    expect($response->json('data.relationships.product_variants.meta.count'))->toBe(5);
})->group('products', 'counts');
