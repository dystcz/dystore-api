<?php

namespace Dystore\Api\Domain\Brands\Concerns;

use Dystore\Api\Domain\Brands\Factories\BrandFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): BrandFactory
    {
        return BrandFactory::new();
    }
}
