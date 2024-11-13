<?php

namespace Dystore\Api\Domain\CartAddresses\Concerns;

use Dystore\Api\Domain\Addresses\Concerns\HasCompanyIdentifiersInMeta;
use Dystore\Api\Domain\CartAddresses\Factories\CartAddressFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HasCompanyIdentifiersInMeta;
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CartAddressFactory
    {
        return CartAddressFactory::new();
    }

    /**
     * Check if the cart address has a shipping option .
     */
    public function hasShippingOption(): bool
    {
        return (bool) $this->shipping_option;
    }
}
