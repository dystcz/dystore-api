<?php

namespace Dystore\Api\Domain\Addresses\Models;

use Dystore\Api\Domain\Addresses\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\Addresses\Contracts\Address as AddressContract;
use Lunar\Models\Address as LunarAddress;

class Address extends LunarAddress implements AddressContract
{
    use InteractsWithLunarApi;
}
