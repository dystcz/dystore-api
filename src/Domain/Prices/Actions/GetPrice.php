<?php

namespace Dystore\Api\Domain\Prices\Actions;

use Illuminate\Support\Facades\Config;
use Lunar\Models\Contracts\Price;

class GetPrice
{
    /**
     * Get price with or withour tax based on config.
     */
    public function __invoke(Price $price, string $priceField = 'price'): \Lunar\DataTypes\Price
    {
        return prices_inc_tax() ? $price->priceIncTax($priceField) : $price->priceExTax($priceField);
    }
}
