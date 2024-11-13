<?php

use Dystore\Api\Domain\Customers\Models\Customer;
use Dystore\Api\Domain\Users\Models\User;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can list customer orders through relationship', function () {
    /** @var TestCase $this */
    $customer = Customer::factory()
        ->withOrder()
        ->has(User::factory())
        ->create();

    $this->actingAs($customer->users->first());

    $response = $this
        ->jsonApi()
        ->expects('orders')
        ->get(serverUrl("/customers/{$customer->getRouteKey()}/orders"));

    $response
        ->assertSuccessful()
        ->assertFetchedMany($customer->orders)
        ->assertDoesntHaveIncluded();
})->group('customers');

it('can count customer orders', function () {
    /** @var TestCase $this */
    $customer = Customer::factory()
        ->withOrder()
        ->has(User::factory())
        ->create();

    $this->actingAs($customer->users->first());

    $response = $this
        ->jsonApi()
        ->expects('customers')
        ->get(serverUrl("/customers/{$customer->getRouteKey()}?with_count=orders"));

    $response
        ->assertSuccessful()
        ->assertFetchedOne($customer);

    expect($response->json('data.relationships.orders.meta.count'))->toBe(1);
})->group('customers');
