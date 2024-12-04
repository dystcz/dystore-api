<?php

namespace Dystore\Api\Domain\Prices\Concerns;

use Dystore\Api\Domain\Prices\Factories\PriceFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithDystoreApi
{
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): PriceFactory
    {
        return PriceFactory::new();
    }
}
