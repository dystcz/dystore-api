<?php

namespace Dystore\Api\Domain\OrderLines\Models;

use Dystore\Api\Domain\OrderLines\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\OrderLines\Contracts\OrderLine as OrderLineContract;
use Lunar\Models\OrderLine as LunarOrderLine;

class OrderLine extends LunarOrderLine implements OrderLineContract
{
    use InteractsWithDystoreApi;
}
