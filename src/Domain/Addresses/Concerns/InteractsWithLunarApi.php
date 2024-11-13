<?php

namespace Dystore\Api\Domain\Addresses\Concerns;

use Dystore\Api\Domain\Addresses\Factories\AddressFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HasCompanyIdentifiersInMeta;
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): AddressFactory
    {
        return AddressFactory::new();
    }
}
