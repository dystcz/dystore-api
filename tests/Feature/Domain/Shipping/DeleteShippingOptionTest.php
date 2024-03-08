<?php

namespace Dystcz\LunarApi\Tests\Feature\Domain\Countries;

use Dystcz\LunarApi\Domain\Customers\Models\Customer;
use Dystcz\LunarApi\Tests\Stubs\Users\User;
use Dystcz\LunarApi\Tests\TestCase;
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
        ->expects('shipping-options')
        ->delete(serverUrl('/shipping-options/1'));

    $response->assertErrorStatus([
        'status' => '405',
        'title' => 'Method Not Allowed',
    ]);
})->group('shipping-options', 'policies');
