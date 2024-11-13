<?php

use Dystore\Api\Domain\Products\Models\Product;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    generateUrls();
});

it('can read default url through relationship', function () {
    /** @var TestCase $this */
    $product = Product::factory()
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('urls')
        ->get(serverUrl("/products/{$product->getRouteKey()}/default_url"));

    $response
        ->assertSuccessful()
        ->assertFetchedOne($product->defaultUrl)
        ->assertDoesntHaveIncluded();
})->group('products');
