<?php

namespace Dystore\Api\Domain\Orders\Events;

use Dystore\Api\Domain\Payments\Contracts\FailedPaymentEventContract;
use Dystore\Api\Domain\Payments\Contracts\PaymentIntent;
use Dystore\Api\Domain\Payments\PaymentAdapters\PaymentAdapter;
use Illuminate\Foundation\Events\Dispatchable;
use Lunar\Models\Contracts\Order as OrderContract;
use Lunar\Models\Order;

class OrderPaymentFailed implements FailedPaymentEventContract
{
    use Dispatchable;

    public function __construct(
        public OrderContract $order,
        public PaymentAdapter $paymentAdapter,
        public PaymentIntent $paymentIntent,
    ) {}

    /**
     * Get payment adapter.
     */
    public function getPaymentAdapter(): PaymentAdapter
    {
        return $this->paymentAdapter;
    }

    /**
     * Get order.
     */
    public function getOrder(): OrderContract
    {
        return $this->order;
    }

    /**
     * Get payment intent.
     */
    public function getPaymentIntent(): PaymentIntent
    {
        return $this->paymentIntent;
    }
}
