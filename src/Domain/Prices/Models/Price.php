<?php

namespace Dystore\Api\Domain\Prices\Models;

use Dystore\Api\Domain\Prices\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\Prices\Contracts\Price as PriceContract;
use Lunar\Models\Price as LunarPrice;

/**
 * @method static \Dystore\Api\Domain\Prices\Builders\PriceBuilder query()
 */
class Price extends LunarPrice implements PriceContract
{
    use InteractsWithDystoreApi;
}
