<?php

namespace Dystore\Api\Domain\Payments\Listeners;

use Dystore\Api\Domain\Orders\Actions\ChangeOrderStatus;
use Dystore\Api\Domain\Orders\Enums\OrderStatus;
use Dystore\Api\Domain\Payments\Contracts\FailedPaymentEventContract;

class HandleFailedPayment
{
    /**
     * Handle the event.
     * Create failed transaction.
     */
    public function handle(FailedPaymentEventContract $event): void
    {
        $paymentIntent = $event->getPaymentIntent();
        $paymentAdapter = $event->getPaymentAdapter();
        $order = $event->getOrder();

        // Change status to awaiting payment
        (new ChangeOrderStatus)($order, OrderStatus::AWAITING_PAYMENT);

        // Create failed transaction
        $paymentAdapter->createIntentTransaction($order->cart, $paymentIntent);
    }
}
