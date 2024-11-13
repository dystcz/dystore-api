<?php

use Dystore\Api\Domain\CartAddresses\Models\CartAddress;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\Customers\Models\Customer;
use Dystore\Api\Domain\Users\Models\User;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->user = User::factory()
        ->has(Customer::factory())
        ->create();

    $this->cart = Cart::factory()->create();

    $this->cartAddress = CartAddress::factory()->for($this->cart)->create();
});

test('cart addresses cannot be deleted', function () {
    /** @var TestCase $this */
    $response = $this->deleteTest('cart_addresses', $this->cartAddress);

    $response->assertErrorStatus([
        'status' => '405',
        'title' => 'Method Not Allowed',
    ]);
})->group('cart_addresses', 'policies');
