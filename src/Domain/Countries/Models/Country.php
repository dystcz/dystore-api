<?php

namespace Dystore\Api\Domain\Countries\Models;

use Dystore\Api\Domain\Countries\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\Countries\Contracts\Country as CountryContract;
use Lunar\Models\Country as LunarCountry;

class Country extends LunarCountry implements CountryContract
{
    use InteractsWithLunarApi;
}
