<?php

namespace Dystore\Api\Domain\OrderAddresses\Concerns;

use Dystore\Api\Domain\Addresses\Concerns\HasCompanyIdentifiersInMeta;
use Dystore\Api\Domain\OrderAddresses\Factories\OrderAddressFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HasCompanyIdentifiersInMeta;
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): OrderAddressFactory
    {
        return OrderAddressFactory::new();
    }
}
