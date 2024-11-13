<?php

use Dystore\Api\Domain\Customers\Models\Customer;
use Dystore\Api\Domain\Prices\Models\Price;
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

test('prices cannot be deleted', function () {
    /** @var TestCase $this */
    $price = Price::factory()->for(Product::factory(), 'priceable')->create();

    $response = $this->deleteTest('prices', $price);

    $response->assertErrorStatus([
        'status' => '404',
        'title' => 'Not Found',
    ]);
})->group('prices', 'policies');
