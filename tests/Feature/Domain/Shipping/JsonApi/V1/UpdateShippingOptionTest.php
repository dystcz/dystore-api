<?php

use Dystore\Api\Domain\Customers\Models\Customer;
use Dystore\Api\Domain\Tags\Models\Tag;
use Dystore\Api\Domain\Users\Models\User;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Lunar\Base\ShippingModifiers;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->user = User::factory()
        ->has(Customer::factory())
        ->create();
});

test('shipping options cannot be updated', function () {
    /** @var TestCase $this */
    $shippingOption = App::get(ShippingModifiers::class)->getModifiers()->first();

    $response = $this->updateTest('shipping_options', Tag::class, []);

    $response->assertErrorStatus([
        'status' => '405',
        'title' => 'Method Not Allowed',
    ]);
})->group('shipping_options', 'policies');
