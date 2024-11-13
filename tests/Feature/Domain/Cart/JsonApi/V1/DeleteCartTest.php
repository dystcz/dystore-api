<?php

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
});

test('carts cannot be deleted', function () {
    /** @var TestCase $this */
    $response = $this->deleteTest('carts', Cart::class);

    $response->assertErrorStatus([
        'status' => '405',
        'title' => 'Method Not Allowed',
    ]);
})->group('carts', 'policies');
