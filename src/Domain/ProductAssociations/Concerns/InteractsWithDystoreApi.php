<?php

namespace Dystore\Api\Domain\ProductAssociations\Concerns;

use Dystore\Api\Domain\ProductAssociations\Builders\ProductAssociationBuilder;
use Dystore\Api\Domain\ProductAssociations\Factories\ProductAssociationFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Query\Builder;

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

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  Builder  $query
     */
    public function newEloquentBuilder($query): ProductAssociationBuilder
    {
        return new ProductAssociationBuilder($query);
    }
}
