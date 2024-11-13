<?php

namespace Dystore\Api\Domain\CartAddresses\Models;

use Dystore\Api\Domain\CartAddresses\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\CartAddresses\Contracts\CartAddress as CartAddressContract;
use Lunar\Models\CartAddress as LunarCartAddress;

class CartAddress extends LunarCartAddress implements CartAddressContract
{
    use InteractsWithLunarApi;
}
