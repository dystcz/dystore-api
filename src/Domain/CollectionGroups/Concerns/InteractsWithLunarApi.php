<?php

namespace Dystore\Api\Domain\CollectionGroups\Concerns;

use Dystore\Api\Domain\CollectionGroups\Factories\CollectionGroupFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): CollectionGroupFactory
    {
        return CollectionGroupFactory::new();
    }
}
