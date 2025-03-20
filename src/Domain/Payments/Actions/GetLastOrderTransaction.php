<?php

namespace Dystore\Api\Domain\Payments\Actions;

use Lunar\Models\Contracts\Order as OrderContract;
use Lunar\Models\Contracts\Transaction as TransactionContract;
use Lunar\Models\Transaction;

class GetLastOrderTransaction
{
    public function __construct(
    ) {}

    /**
     * Get last order transaction.
     */
    public function __invoke(OrderContract $order, ?string $driver = null, ?string $type = null): ?TransactionContract
    {
        return Transaction::modelClass()::query()
            ->where('order_id', $order->id)
            ->when($type, fn ($query) => $query->where('type', $type))
            ->when($driver, fn ($query) => $query->where('driver', $driver))
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
