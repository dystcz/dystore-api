<?php

use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\Payments\Contracts\PaymentIntent;
use Dystore\Api\Domain\Payments\PaymentAdapters\PaymentAdaptersRegister;
use Dystore\Api\Tests\Stubs\Payments\PaymentAdapters\TestPaymentAdapter;
use Dystore\Api\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->cart = Cart::factory()
        ->withAddresses()
        ->withLines()
        ->create();

    $this->cart->createOrder();

    TestPaymentAdapter::register();
});

it('handles creation of payment intent', function () {
    /** @var TestCase $this */
    $payment = App::make(PaymentAdaptersRegister::class)->get('test');

    $intent = $payment->createIntent($this->cart);

    expect($intent)->toBeInstanceOf(PaymentIntent::class);
})->group('payments');

it('handles webhooks', function () {
    /** @var TestCase $this */
    $payment = App::make(PaymentAdaptersRegister::class)->get('test');

    $response = $payment->handleWebhook(new Request);

    expect($response)->toBeInstanceOf(JsonResponse::class);
})->group('payments');
