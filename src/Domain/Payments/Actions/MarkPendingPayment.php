<?php

namespace Dystore\Api\Domain\Payments\Actions;

use Dystore\Api\Domain\Orders\Actions\ChangeOrderStatus;
use Dystore\Api\Domain\Orders\Enums\OrderStatus;
use Lunar\Models\Contracts\Order as OrderContract;

class MarkPendingPayment
{
    /**
     * Change order status to pending payment.
     */
    public function __invoke(OrderContract $order): OrderContract
    {
        $order = (new ChangeOrderStatus)($order, OrderStatus::PENDING_PAYMENT);

        return $order;
    }
}
