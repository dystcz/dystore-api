<?php

use Dystore\Api\Domain\Products\Factories\ProductFactory;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can read highest price through relationship', function () {
    /** @var TestCase $this */
    $product = ProductFactory::new()
        ->withPrices(3)
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('prices')
        ->get(serverUrl("/products/{$product->getRouteKey()}/highest_price"));

    $response
        ->assertSuccessful()
        ->assertFetchedOne($product->prices->sortByDesc('price')->first())
        ->assertDoesntHaveIncluded();
})->group('products');
