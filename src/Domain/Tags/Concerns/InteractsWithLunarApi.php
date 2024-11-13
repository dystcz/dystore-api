<?php

namespace Dystore\Api\Domain\Tags\Concerns;

use Dystore\Api\Domain\Tags\Factories\TagFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): TagFactory
    {
        return TagFactory::new();
    }
}
