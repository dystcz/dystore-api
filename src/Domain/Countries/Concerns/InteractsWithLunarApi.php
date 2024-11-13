<?php

namespace Dystore\Api\Domain\Countries\Concerns;

use Dystore\Api\Domain\Countries\Factories\CountryFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CountryFactory
    {
        return CountryFactory::new();
    }
}
