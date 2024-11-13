<?php

use Dystore\Api\Domain\Media\Factories\MediaFactory;
use Dystore\Api\Domain\Prices\Factories\PriceFactory;
use Dystore\Api\Domain\ProductAssociations\Models\ProductAssociation;
use Dystore\Api\Domain\Products\Factories\ProductFactory;
use Dystore\Api\Domain\Products\Models\Product;
use Dystore\Api\Domain\ProductVariants\Factories\ProductVariantFactory;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can read products associations', function () {
    /** @var TestCase $this */
    /** @var Product $productA */
    $productA = ProductFactory::new()->create();

    /** @var Product $productB */
    $productB = ProductFactory::new()
        ->has(
            ProductVariantFactory::new()->has(PriceFactory::new()),
            'variants'
        )
        ->has(MediaFactory::new()->thumbnail(), 'thumbnail')
        ->create();

    $productA->associate(
        $productB,
        ProductAssociation::CROSS_SELL
    );

    $response = $this
        ->jsonApi()
        ->expects('products')
        ->includePaths(
            'product_associations',
            // 'product_associations.target.thumbnail'
        )
        ->get(serverUrl("/products/{$productA->getRouteKey}()"));

    $response->assertFetchedOne($productA);
    // ->assertIsIncluded('product_associations', $productA->associations->first())
    // ->assertIsIncluded('products', $productB)
    // ->assertIsIncluded('media', $productB->thumbnail)
    // ->assertIsIncluded('variants', $productB->variants->first())
    // ->assertIsIncluded('prices', $productB->variants->first()->prices->first());
})->group('product_associations');
