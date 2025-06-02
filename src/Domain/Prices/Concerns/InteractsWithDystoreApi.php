<?php

namespace Dystore\Api\Domain\Prices\Concerns;

use Dystore\Api\Domain\Prices\Builders\PriceBuilder;
use Dystore\Api\Domain\Prices\Factories\PriceFactory;
use Dystore\Api\Domain\Prices\Models\Price;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithDystoreApi
{
    use HashesRouteKey;

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     */
    public function newEloquentBuilder($query): PriceBuilder
    {
        return new PriceBuilder($query);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): PriceFactory
    {
        return PriceFactory::new();
    }

    /**
     * Return the price exclusive of tax.
     */
    public function priceExTax(string $priceField = 'price'): \Lunar\DataTypes\Price
    {
        /** @var Price $model */
        $model = $this;

        if (! prices_inc_tax()) {
            return $model->price;
        }

        $priceExTax = clone $model->{$priceField};

        $priceExTax->value = (int) round($priceExTax->value / (1 + $model->getPriceableTaxRate()));

        return $priceExTax;
    }

    /**
     * Return the price inclusive of tax.
     */
    public function priceIncTax(string $priceField = 'price'): int|\Lunar\DataTypes\Price
    {
        /** @var Price $model */
        $model = $this;

        if (prices_inc_tax()) {
            return $model->{$priceField};
        }

        $priceIncTax = clone $model->{$priceField};
        $priceIncTax->value = (int) round($priceIncTax->value * (1 + $model->getPriceableTaxRate()));

        return $priceIncTax;
    }
}
