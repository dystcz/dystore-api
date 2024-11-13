<?php

use Dystore\Api\Domain\Collections\Models\Collection;
use Dystore\Api\Domain\Prices\Models\Price;
use Dystore\Api\Domain\Products\Models\Product;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariant;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can read collection detail', function () {
    /** @var TestCase $this */
    $model = Collection::factory()->create();

    $response = $this
        ->jsonApi()
        ->expects('collections')
        ->get(serverUrl("/collections/{$model->getRouteKey()}"));

    $response
        ->assertSuccessful()
        ->assertFetchedOne($model);

})->group('collections');

it('can read products in a collection', function () {
    /** @var TestCase $this */
    $model = Collection::factory()
        ->has(
            Product::factory()
                ->has(
                    ProductVariant::factory()
                        ->has(
                            Price::factory()
                        )
                        ->count(2),
                    'variants'
                )
                ->count(3)
        )
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('collections')
        ->includePaths('products')
        ->get(serverUrl("/collections/{$model->getRouteKey()}"));

    $response
        ->assertSuccessful()
        ->assertFetchedOne($model)
        ->assertIncluded(
            mapModelsToResponseData(
                'products',
                $model->products,
            ),
        );

})->group('collections');

it('can show a collection with included default url', function () {
    /** @var TestCase $this */
    generateUrls();

    $model = Collection::factory()
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('collections')
        ->includePaths('default_url')
        ->get(serverUrl('/collections/'.$model->getRouteKey()));

    $response
        ->assertSuccessful()
        ->assertFetchedOne($model)
        ->assertIsIncluded('urls', $model->defaultUrl);
})->group('collections');

it('can show a collection with correctly mapped attributes', function () {
    /** @var TestCase $this */
    generateUrls();

    $model = Collection::factory()
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('collections')
        ->get(serverUrl('/collections/'.$model->getRouteKey()));

})->group('collections')->todo();
