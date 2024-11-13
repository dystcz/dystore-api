<?php

namespace Dystore\Api\Domain\ProductOptions\Models;

use Dystore\Api\Domain\ProductOptions\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\ProductOptions\Contracts\ProductOption as ProductOptionContract;
use Lunar\Models\ProductOption as LunarProductOption;

class ProductOption extends LunarProductOption implements ProductOptionContract
{
    use InteractsWithLunarApi;
}
