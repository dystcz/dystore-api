<?php

use Dystore\Api\Domain\Products\Factories\ProductFactory;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can read thumbnail through relationship', function () {
    /** @var TestCase $this */
    $product = ProductFactory::new()
        ->withThumbnail()
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('media')
        ->get(serverUrl("/products/{$product->getRouteKey()}/thumbnail"));

    $response
        ->assertSuccessful()
        ->assertFetchedOne($product->thumbnail)
        ->assertDoesntHaveIncluded();
})->group('products');
