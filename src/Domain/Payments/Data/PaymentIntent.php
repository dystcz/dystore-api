<?php

namespace Dystcz\LunarApi\Domain\Payments\Data;

use Dystcz\LunarApi\Domain\Payments\Contracts\PaymentIntent as PaymentIntentContract;
use Dystcz\LunarApi\Domain\Payments\Enums\PaymentIntentStatus;

class PaymentIntent implements PaymentIntentContract
{
    /**
     * @param  array<string,mixed>  $meta
     */
    public function __construct(
        public readonly mixed $intent,
        public array $meta = [],
    ) {}

    /**
     * Get ID.
     */
    public function getId(): mixed
    {
        return $this->intent->id;
    }

    /**
     * Get amount.
     */
    public function getAmount(): int
    {
        return $this->intent->amount;
    }

    /**
     * Get status.
     */
    public function getStatus(): string
    {
        return PaymentIntentStatus::INTENT->value;
    }

    /**
     * Get client secret.
     */
    public function getClientSecret(): string
    {
        return $this->intent->client_secret;
    }

    /**
     * Get meta.
     *
     * @return array<string,mixed>
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'amount' => $this->getAmount(),
            'status' => $this->getStatus(),
            'client_secret' => $this->getClientSecret(),
            'meta' => $this->getMeta(),
        ];
    }
}
