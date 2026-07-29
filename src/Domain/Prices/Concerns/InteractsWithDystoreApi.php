<?php

namespace Dystore\Api\Domain\Prices\Concerns;

use Dystore\Api\Domain\Prices\Builders\PriceBuilder;
use Dystore\Api\Domain\Prices\Factories\PriceFactory;
use Dystore\Api\Domain\Prices\Models\Price;
use Dystore\Api\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Query\Builder;
use Lunar\Models\Contracts\TaxZone as TaxZoneContract;

trait InteractsWithDystoreApi
{
    use HashesRouteKey;

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  Builder  $query
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
    public function priceExTax(?TaxZoneContract $taxZone = null): \Lunar\DataTypes\Price
    {
        /** @var Price $model */
        $model = $this;

        if (! prices_inc_tax()) {
            return $model->price;
        }

        $priceExTax = clone $model->price;

        $priceExTax->value = (int) round($priceExTax->value / (1 + $model->getPriceableTaxRate()));

        return $priceExTax;
    }

    /**
     * Return the price inclusive of tax.
     */
    public function priceIncTax(?TaxZoneContract $taxZone = null): int|\Lunar\DataTypes\Price
    {
        /** @var Price $model */
        $model = $this;

        if (prices_inc_tax()) {
            return $model->price;
        }

        $priceIncTax = clone $model->price;
        $priceIncTax->value = (int) round($priceIncTax->value * (1 + $model->getPriceableTaxRate()));

        return $priceIncTax;
    }
}
