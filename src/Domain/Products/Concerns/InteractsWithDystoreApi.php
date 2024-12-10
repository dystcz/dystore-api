<?php

namespace Dystore\Api\Domain\Products\Concerns;

use Dystore\Api\Domain\Products\Actions\IsPurchasable;
use Dystore\Api\Domain\Products\Builders\ProductBuilder;
use Dystore\Api\Domain\Products\Factories\ProductFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute as Attr;

trait InteractsWithDystoreApi
{
    use HashesRouteKey;
    use HasRelationships;
    use InteractsWithAvailability;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return ProductBuilder|static
     */
    public function newEloquentBuilder($query): Builder
    {
        return new ProductBuilder($query);
    }

    /**
     * Get purchaseble attribute.
     */
    public function isPurchasable(): Attr
    {
        return Attr::make(
            get: fn () => (new IsPurchasable)($this),
        );
    }
}
