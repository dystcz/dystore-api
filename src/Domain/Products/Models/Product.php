<?php

namespace Dystore\Api\Domain\Products\Models;

use Dystore\Api\Domain\Products\Builders\ProductBuilder;
use Dystore\Api\Domain\Products\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\Products\Contracts\Product as ProductContract;
use Lunar\Models\Product as LunarProduct;

/**
 * @method static ProductBuilder query()
 */
class Product extends LunarProduct implements ProductContract
{
    use InteractsWithDystoreApi;
}
