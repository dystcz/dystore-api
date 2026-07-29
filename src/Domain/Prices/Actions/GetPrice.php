<?php

namespace Dystore\Api\Domain\Prices\Actions;

use Lunar\Models\Contracts\Price;

class GetPrice
{
    /**
     * Get price with or without tax based on config.
     *
     * @param  'price'|'compare_price'  $priceField
     */
    public function __invoke(Price $price, string $priceField = 'price'): \Lunar\DataTypes\Price
    {
        if ($priceField === 'compare_price') {
            return prices_inc_tax() ? $price->comparePriceIncTax() : $price->compare_price;
        }

        return prices_inc_tax() ? $price->priceIncTax() : $price->priceExTax();
    }
}
