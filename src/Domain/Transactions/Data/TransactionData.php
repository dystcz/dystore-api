<?php

namespace Dystcz\LunarApi\Domain\Transactions\Data;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class TransactionData implements Arrayable
{
    public function __construct(
        public int $order_id,
        public bool $success,
        public string $type,
        public string $driver,
        public float $amount,
        public string $reference,
        public string $status,
        public string $card_type,
        public ?string $notes = null,
        public ?int $parent_transaction_id = null,
        public ?string $last_four = null,
        public array $meta = [],
        public ?Carbon $captured_at = null
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'order_id' => $this->order_id,
            'success' => $this->success,
            'type' => $this->type,
            'driver' => $this->driver,
            'amount' => $this->amount,
            'reference' => $this->reference,
            'status' => $this->status,
            'card_type' => $this->card_type,
            'notes' => $this->notes,
            'parent_transaction_id' => $this->parent_transaction_id,
            'last_four' => $this->last_four,
            'meta' => $this->meta,
            'captured_at' => $this->captured_at?->toDateTimeString(),
        ];
    }
}