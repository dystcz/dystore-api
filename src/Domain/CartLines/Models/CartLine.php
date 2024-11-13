<?php

namespace Dystore\Api\Domain\CartLines\Models;

use Dystore\Api\Domain\CartLines\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\CartLines\Contracts\CartLine as CartLineContract;
use Lunar\Models\CartLine as LunarCartLine;

class CartLine extends LunarCartLine implements CartLineContract
{
    use InteractsWithLunarApi;
}
