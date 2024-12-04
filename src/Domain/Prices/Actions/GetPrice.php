<?php

namespace Dystore\Api\Domain\Prices\Actions;

use Illuminate\Support\Facades\Config;
use Lunar\Base\Purchasable;
use Lunar\DataTypes\Price;

class GetPrice
{
    private bool $withTax;

    private GetPriceWithDefaultTax $getPriceWithDefaultTax;

    public function __construct()
    {
        $this->withTax = Config::get('lunar.pricing.stored_inclusive_of_tax');

        $this->getPriceWithDefaultTax = new GetPriceWithDefaultTax;
    }

    /**
     * Get price with or withour tax based on config.
     */
    public function __invoke(Price $price, Purchasable $purchasable): Price
    {
        // NOTE: If prices are stored inclusive of tax, we can return the price as is
        if ($this->withTax) {
            return $price;
        }

        return ($this->getPriceWithDefaultTax)($price, $purchasable);
    }
}
