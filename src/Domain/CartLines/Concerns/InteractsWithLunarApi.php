<?php

namespace Dystore\Api\Domain\CartLines\Concerns;

use Dystore\Api\Domain\CartLines\Factories\CartLineFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CartLineFactory
    {
        return CartLineFactory::new();
    }
}
