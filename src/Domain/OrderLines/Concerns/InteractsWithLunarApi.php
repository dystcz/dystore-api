<?php

namespace Dystore\Api\Domain\OrderLines\Concerns;

use Dystore\Api\Domain\OrderLines\Factories\OrderLineFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): OrderLineFactory
    {
        return OrderLineFactory::new();
    }
}
