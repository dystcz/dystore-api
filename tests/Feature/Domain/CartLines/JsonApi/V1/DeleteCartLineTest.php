<?php

use Dystore\Api\Domain\CartLines\Models\CartLine;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\Prices\Models\Price;
use Dystore\Api\Domain\ProductVariants\Factories\ProductVariantFactory;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariant;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Lunar\Facades\CartSession;
use Lunar\Models\Currency;

uses(TestCase::class, RefreshDatabase::class);

it('can remove a cart line', function () {
    /** @var TestCase $this */
    $currency = Currency::getDefault();

    $cart = Cart::factory()->create([
        'currency_id' => $currency->id,
    ]);

    $purchasable = ProductVariant::factory()->state(['stock' => 1])->create();

    Price::factory()->create([
        'price' => 100,
        'min_quantity' => 1,
        'currency_id' => $currency->id,
        'priceable_type' => $purchasable->getMorphClass(),
        'priceable_id' => $purchasable->id,
    ]);

    $cart->add($purchasable, 1);

    $this->assertCount(1, $cart->refresh()->lines);

    $cartLine = $cart->lines->first();

    CartSession::use($cart);

    $response = $this
        ->jsonApi()
        ->delete('/api/v1/cart_lines/'.$cartLine->getRouteKey());

    $response->assertNoContent();

    $this->assertDatabaseMissing($cartLine->getTable(), [
        'id' => $cartLine->getKey(),
    ]);
})->group('cart_lines');

test('only the owner of the cart can delete cart lines', function () {
    /** @var TestCase $this */
    $cartLine = CartLine::factory()
        ->for(ProductVariantFactory::new()->state(['stock' => 1]), 'purchasable')
        ->create();

    $response = $this
        ->jsonApi()
        ->delete('/api/v1/cart_lines/'.$cartLine->getRouteKey());

    $response->assertErrorStatus([
        'detail' => 'Unauthenticated.',
        'status' => '401',
        'title' => 'Unauthorized',
    ]);
})->group('cart_lines', 'policies');
