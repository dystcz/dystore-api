<?php

namespace Dystore\Api\Domain\OrderLines\Models;

use Dystore\Api\Domain\OrderLines\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\OrderLines\Contracts\OrderLine as OrderLineContract;
use Lunar\Models\OrderLine as LunarOrderLine;

class OrderLine extends LunarOrderLine implements OrderLineContract
{
    use InteractsWithLunarApi;
}
