<?php

use Dystore\Api\Domain\Customers\Models\Customer;
use Dystore\Api\Domain\Products\Models\Product;
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

test('prices cannot be updated', function () {
    /** @var TestCase $this */
    $response = $this->updateTest('prices', Product::class, []);

    $response->assertErrorStatus([
        'status' => '404',
        'title' => 'Not Found',
    ]);
})->group('prices', 'policies');
