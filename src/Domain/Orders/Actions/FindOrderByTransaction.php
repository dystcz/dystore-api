<?php

namespace Dystore\Api\Domain\Orders\Actions;

use Dystore\Api\Domain\Payments\Data\PaymentIntent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Lunar\Models\Order;

class FindOrderByTransaction
{
    /**
     * Find order by intent.
     *
     * @throws ModelNotFoundException
     */
    public function __invoke(PaymentIntent $intent): ?Order
    {
        return Order::modelClass()::query()
            ->whereHas('transactions', fn ($query) => $query->where('reference', $intent->getId()))
            ->firstOrFail();
    }
}
