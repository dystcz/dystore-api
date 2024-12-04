<?php

namespace Dystore\Api\Domain\CartAddresses\Models;

use Dystore\Api\Domain\CartAddresses\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\CartAddresses\Contracts\CartAddress as CartAddressContract;
use Lunar\Models\CartAddress as LunarCartAddress;

class CartAddress extends LunarCartAddress implements CartAddressContract
{
    use InteractsWithDystoreApi;
}
