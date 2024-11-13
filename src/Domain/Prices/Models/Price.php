<?php

namespace Dystore\Api\Domain\Prices\Models;

use Dystore\Api\Domain\Prices\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\Prices\Contracts\Price as PriceContract;
use Lunar\Models\Price as LunarPrice;

class Price extends LunarPrice implements PriceContract
{
    use InteractsWithLunarApi;
}
