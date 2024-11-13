<?php

namespace Dystore\Api\Domain\Currencies\Concerns;

use Dystore\Api\Domain\Currencies\Factories\CurrencyFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CurrencyFactory
    {
        return CurrencyFactory::new();
    }
}
