<?php

use Dystcz\LunarApi\Domain\Prices\Models\Price;
use Dystcz\LunarApi\Domain\Products\Models\Product;
use Dystcz\LunarApi\Domain\ProductVariants\Models\ProductVariant;
use Dystcz\LunarApi\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can list bare product variants', function () {
    /** @var TestCase $this */
    $variants = ProductVariant::factory()
        ->has(Price::factory())
        ->count(2)
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('product_variants')
        ->get(serverUrl('/product_variants'));

    $response
        ->assertSuccessful()
        ->assertFetchedMany($variants)
        ->assertDoesntHaveIncluded();
})->group('product_variants');

it('cannot list variants of unpublished products', function () {
    /** @var TestCase $this */
    $variants = ProductVariant::factory()
        ->for(Product::factory()->create(['status' => 'draft']))
        ->has(Price::factory())
        ->count(2)
        ->create();

    $response = $this
        ->jsonApi()
        ->expects('product_variants')
        ->get(serverUrl('/product_variants'));

    $response
        ->assertSuccessful()
        ->assertFetchedNone()
        ->assertDoesntHaveIncluded();
})->group('variants', 'policies');
