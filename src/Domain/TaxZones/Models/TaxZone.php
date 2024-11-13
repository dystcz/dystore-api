<?php

namespace Dystore\Api\Domain\TaxZones\Models;

use Dystore\Api\Domain\TaxZones\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\TaxZones\Contracts\TaxZone as TaxZoneContract;
use Lunar\Models\TaxZone as LunarTaxZone;

class TaxZone extends LunarTaxZone implements TaxZoneContract
{
    use InteractsWithLunarApi;
}
