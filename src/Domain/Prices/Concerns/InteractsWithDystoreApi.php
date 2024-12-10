<?php

namespace Dystore\Api\Domain\Prices\Concerns;

use Dystore\Api\Domain\Prices\Builders\PriceBuilder;
use Dystore\Api\Domain\Prices\Factories\PriceFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Eloquent\Builder;

trait InteractsWithDystoreApi
{
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): PriceFactory
    {
        return PriceFactory::new();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return PriceBuilder|static
     */
    public function newEloquentBuilder($query): Builder
    {
        return new PriceBuilder($query);
    }
}
