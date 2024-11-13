<?php

namespace Dystore\Api\Domain\ProductTypes\Models;

use Dystore\Api\Domain\ProductTypes\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\ProductTypes\Contracts\ProductType as ProductTypeContract;
use Lunar\Models\ProductType as LunarProductType;

class ProductType extends LunarProductType implements ProductTypeContract
{
    use InteractsWithLunarApi;
}
