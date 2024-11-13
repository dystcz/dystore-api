<?php

use Dystore\Api\Domain\Carts\Factories\CartFactory;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\Orders\Enums\OrderStatus;
use Dystore\Api\Domain\Orders\Events\OrderStatusChanged;
use Dystore\Api\Domain\Orders\Models\Order;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */

    /** @var Cart $cart */
    $cart = CartFactory::new()
        ->withAddresses()
        ->withLines()
        ->create();

    $order = $cart->createOrder();

    $this->order = Order::query()->where($order->getKeyName(), $order->getKey())->firstOrFail();
});

it('can change order status to pending payment', function () {
    /** @var TestCase $this */
    Event::fake(OrderStatusChanged::class);

    $url = URL::signedRoute(
        'v1.orders.markAwaitingPayment', ['order' => $this->order->getRouteKey()]
    );

    $this->order->update(['status' => OrderStatus::PENDING_PAYMENT->value]);

    $response = $this
        ->jsonApi()
        ->expects('orders')
        ->withData([
            'type' => 'orders',
            'id' => (string) $this->order->getRouteKey(),
        ])
        ->patch($url);

    $response->assertSuccessful();

    $id = $response->getId();

    $this->assertDatabaseHas($this->order->getTable(), [
        'id' => $this->order->getKey(),
        'status' => OrderStatus::AWAITING_PAYMENT->value,
    ]);

    Event::assertDispatched(
        OrderStatusChanged::class,
        fn (OrderStatusChanged $event) => $event->order->getKey() === $this->order->getKey(),
    );
});
