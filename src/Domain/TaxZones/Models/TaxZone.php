<?php

namespace Dystcz\LunarApi\Domain\TaxZones\Models;

use Dystcz\LunarApi\Base\Attributes\ReplaceModel;
use Dystcz\LunarApi\Domain\TaxZones\Concerns\InteractsWithLunarApi;
use Dystcz\LunarApi\Domain\TaxZones\Contracts\TaxZone as TaxZoneContract;
use Lunar\Models\Contracts\TaxZone as LunarTaxZoneContract;
use Lunar\Models\TaxZone as LunarTaxZone;

#[ReplaceModel(LunarTaxZoneContract::class)]
class TaxZone extends LunarTaxZone implements TaxZoneContract
{
    use InteractsWithLunarApi;
}
