<?php

use Dystore\Api\Domain\Customers\Models\Customer;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariant;
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

test('product variants cannot be updated', function () {
    /** @var TestCase $this */
    $response = $this->updateTest('product_variants', ProductVariant::class, []);

    $response->assertErrorStatus([
        'status' => '405',
        'title' => 'Method Not Allowed',
    ]);
})->group('variants', 'policies');
