<?php

namespace Dystcz\LunarApi\Domain\Prices\Actions;

use Illuminate\Support\Facades\Config;
use Lunar\DataTypes\Price;

class GetPrice
{
    private bool $withTax;

    private GetPriceWithDefaultTax $getPriceWithDefaultTax;

    public function __construct()
    {
        $this->withTax = Config::get('lunar-api.taxation.prices_with_default_tax');

        $this->getPriceWithDefaultTax = new GetPriceWithDefaultTax;
    }

    /**
     * Get price with or withour tax based on config.
     */
    public function __invoke(Price $price): Price
    {
        if ($this->withTax) {
            return ($this->getPriceWithDefaultTax)($price->priceable, $price);
        }

        return $price;
    }
}
