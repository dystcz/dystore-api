<?php

use Dystore\Api\Domain\Customers\Models\Customer;
use Dystore\Api\Domain\ProductAssociations\Models\ProductAssociation;
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

test('users cannot update product associations', function () {
    /** @var TestCase $this */
    $response = $this->updateTest('product_associations', ProductAssociation::class, []);

    $response->assertErrorStatus([
        'status' => '404',
        'title' => 'Not Found',
    ]);
})->group('product_associations', 'policies');
