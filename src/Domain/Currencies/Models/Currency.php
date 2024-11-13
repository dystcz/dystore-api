<?php

namespace Dystore\Api\Domain\Currencies\Models;

use Dystore\Api\Domain\Currencies\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\Currencies\Contracts\Currency as CurrencyContract;
use Lunar\Models\Currency as LunarCurrency;

class Currency extends LunarCurrency implements CurrencyContract
{
    use InteractsWithLunarApi;
}
