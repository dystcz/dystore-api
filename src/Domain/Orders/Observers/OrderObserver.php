<?php

namespace Dystore\Api\Domain\Orders\Observers;

use Dystore\Api\Domain\Orders\Events\OrderCreated;
use Dystore\Api\Domain\Orders\Events\OrderStatusChanged;
use Dystore\Api\Domain\Orders\Models\Order;
use Illuminate\Support\Facades\Event;
use Lunar\Models\Contracts\Order as OrderContract;

class OrderObserver
{
    public function created(OrderContract $order): void
    {
        /** @var Order $order */
        OrderCreated::dispatch($order);
    }

    public function updating(OrderContract $order): void
    {
        //
    }

    public function updated(OrderContract $order): void
    {
        /** @var Order $order */
        if ($order->wasChanged('status')) {
            Event::dispatch(
                new OrderStatusChanged(
                    order: $order,
                    newStatus: $order->status,
                    oldStatus: $order->getOriginal('status'),
                ),
            );
        }
    }
}
