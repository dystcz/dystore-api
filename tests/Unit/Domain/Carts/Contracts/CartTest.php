<?php

use Dystore\Api\Domain\Carts\Contracts\CurrentSessionCart;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;

uses(TestCase::class, RefreshDatabase::class);

it('can bind cart contract to model implementation', function () {
    /** @var TestCase $this */
    $cart = App::make(CurrentSessionCart::class);

    $this->assertInstanceOf(Cart::class, $cart);

})->group('carts', 'carts.model');
