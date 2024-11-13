<?php

use Dystore\Api\Domain\Customers\Models\Customer;
use Dystore\Api\Domain\Orders\Models\Order;
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

test('orders cannot be deleted', function () {
    /** @var TestCase $this */
    $response = $this->deleteTest('orders', Order::class);

    $response->assertErrorStatus([
        'status' => '405',
        'title' => 'Method Not Allowed',
    ]);
})->group('orders', 'policies');
