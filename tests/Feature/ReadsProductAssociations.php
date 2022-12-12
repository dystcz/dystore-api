<?php

use Dystcz\LunarApi\Domain\Media\Factories\MediaFactory;
use Dystcz\LunarApi\Domain\Products\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Lunar\Database\Factories\PriceFactory;
use Lunar\Database\Factories\ProductFactory;
use Lunar\Database\Factories\ProductVariantFactory;

uses(\Dystcz\LunarApi\Tests\TestCase::class, RefreshDatabase::class);

it('can read products associations', function () {
    /** @var Product $productB */
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
        \Lunar\Models\ProductAssociation::CROSS_SELL
    );

    $self = 'http://localhost/api/v1/products/'.$productA->getRouteKey();

    $response = $this
        ->jsonApi()
        ->expects('products')
        ->includePaths(
            'associations.target.variants.prices',
            'associations.target.thumbnail'
        )
        ->get($self);

    $response->assertFetchedOne($productA)
        ->assertIsIncluded('associations', $productA->associations->first())
        ->assertIsIncluded('products', $productB)
        ->assertIsIncluded('thumbnails', $productB->thumbnail)
        ->assertIsIncluded('variants', $productB->variants->first())
        ->assertIsIncluded('prices', $productB->variants->first()->prices->first());
});
