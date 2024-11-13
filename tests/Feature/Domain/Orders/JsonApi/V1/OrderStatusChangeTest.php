<?php

use Dystore\Api\Domain\Carts\Factories\CartFactory;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\Orders\Enums\OrderStatus;
use Dystore\Api\Domain\Orders\Events\OrderStatusChanged;
use Dystore\Api\Domain\Orders\Models\Order;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

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

it('sends order status changed event after order status was changed', function () {
    /** @var TestCase $this */
    Event::fake(OrderStatusChanged::class);

    $this->order->update(['status' => OrderStatus::PENDING_PAYMENT->value]);

    Event::assertDispatched(
        OrderStatusChanged::class,
        fn (OrderStatusChanged $event) => $event->order->getKey() === $this->order->getKey(),
    );
})->group('orders');
