<?php

namespace Dystore\Api\Domain\ProductAssociations\Concerns;

use Dystore\Api\Domain\ProductAssociations\Factories\ProductAssociationFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithDystoreApi
{
    use HashesRouteKey;

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): ProductAssociationFactory
    {
        return ProductAssociationFactory::new();
    }
}
