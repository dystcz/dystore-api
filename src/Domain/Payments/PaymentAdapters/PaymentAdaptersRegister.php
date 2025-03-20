<?php

namespace Dystore\Api\Domain\Payments\PaymentAdapters;

use Illuminate\Support\Facades\App;

class PaymentAdaptersRegister
{
    /**
     * @var class-string<PaymentAdapter>[]
     */
    protected array $adapters = [];

    /**
     * Register payment adapter.
     *
     * @param  class-string<PaymentAdapter>  $adapter
     */
    public function add(string $type, string $adapter): void
    {
        $this->adapters[$type] = $adapter;
    }

    /**
     * Check if payment adapter is registered.
     */
    public function has(string $type): bool
    {
        return array_key_exists($type, $this->adapters);
    }

    /**
     * Get payment adapter.
     */
    public function get(string $type): PaymentAdapter
    {
        if (! $this->has($type)) {
            throw new \RuntimeException("Payment adapter for ['{$type}'] is not registered");
        }

        return App::make($this->adapters[$type]);
    }
}
