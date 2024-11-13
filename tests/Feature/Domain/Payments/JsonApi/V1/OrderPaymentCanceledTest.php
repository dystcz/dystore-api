<?php

use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\Orders\Enums\OrderStatus;
use Dystore\Api\Domain\Orders\Events\OrderPaymentCanceled;
use Dystore\Api\Domain\Payments\Listeners\HandleFailedPayment;
use Dystore\Api\Domain\Payments\PaymentAdapters\PaymentAdaptersRegister;
use Dystore\Api\Domain\Transactions\Models\Transaction;
use Dystore\Api\Tests\Stubs\Payments\PaymentAdapters\TestPaymentAdapter;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */

    /** @var Cart $cart */
    $cart = Cart::factory()
        ->withAddresses()
        ->withLines()
        ->create();

    $this->order = $cart->createOrder();
    $this->cart = $cart;

    TestPaymentAdapter::register();
});

it('can handle canceled payment', function () {
    /** @var TestCase $this */
    Event::fake();

    /** @var TestPaymentAdapter $paymentAdapter */
    $paymentAdapter = App::make(PaymentAdaptersRegister::class)->get('test');

    $paymentIntent = $paymentAdapter->createIntent($this->cart);

    OrderPaymentCanceled::dispatch($this->order, $paymentAdapter, $paymentIntent);

    Event::assertListening(
        OrderPaymentCanceled::class,
        HandleFailedPayment::class
    );

    $this->assertDatabaseHas((new Transaction)->getTable(), [
        'order_id' => $this->order->id,
        'reference' => $paymentIntent->getId(),
        'status' => $paymentIntent->getStatus(),
    ]);

    $this->assertDatabaseHas($this->order->getTable(), [
        'status' => OrderStatus::AWAITING_PAYMENT->value,
    ]);

})->group('payments');
