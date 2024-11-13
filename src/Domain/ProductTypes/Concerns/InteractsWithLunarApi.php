<?php

namespace Dystore\Api\Domain\ProductTypes\Concerns;

use Dystore\Api\Domain\ProductTypes\Factories\ProductTypeFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): ProductTypeFactory
    {
        return ProductTypeFactory::new();
    }
}
