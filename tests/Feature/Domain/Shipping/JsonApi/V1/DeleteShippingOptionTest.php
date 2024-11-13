<?php

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

test('shipping options cannot be deleted', function () {
    /** @var TestCase $this */
    $response = $this
        ->jsonApi()
        ->expects('shipping_options')
        ->delete(serverUrl('/shipping_options/1'));

    $response->assertErrorStatus([
        'status' => '405',
        'title' => 'Method Not Allowed',
    ]);
})->group('shipping_options', 'policies');
