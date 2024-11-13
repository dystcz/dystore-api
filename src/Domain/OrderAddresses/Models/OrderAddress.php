<?php

namespace Dystore\Api\Domain\OrderAddresses\Models;

use Dystore\Api\Domain\OrderAddresses\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\OrderAddresses\Contracts\OrderAddress as OrderAddressContract;
use Lunar\Models\OrderAddress as LunarOrderAddress;

class OrderAddress extends LunarOrderAddress implements OrderAddressContract
{
    use InteractsWithLunarApi;
}
