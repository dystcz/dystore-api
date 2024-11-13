<?php

namespace Dystore\Api\Domain\Transactions\Actions;

use Dystore\Api\Domain\Transactions\Data\TransactionData;
use Lunar\Models\Transaction;

class CreateTransaction
{
    /**
     * Create or update transaction.
     */
    public function __invoke(TransactionData $transactionData): Transaction
    {
        return Transaction::modelClass()::updateOrCreate([
            'order_id' => $transactionData->order_id,
            'parent_transaction_id' => $transactionData->parent_transaction_id,
            'reference' => $transactionData->reference,
            'status' => $transactionData->status,
            'success' => $transactionData->success,
        ], $transactionData->toArray());
    }
}
