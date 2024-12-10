<?php

namespace Dystore\Api\Domain\Products\Models;

use Dystore\Api\Domain\Products\Builders\ProductBuilder;
use Dystore\Api\Domain\Products\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\Products\Contracts\Product as ProductContract;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Lunar\Models\Product as LunarProduct;
use Lunar\Models\ProductOptionValue;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;

/**
 * @method static ProductBuilder query()
 * @method MorphToMany attributes() Get the mapped attributes relation.
 * @method HasManyThrough prices() Get prices relation through variants.
 * @method HasManyThrough basePrices() Get base prices relation through variants.
 * @method HasOneThrough lowestPrice() Get the lowest price relation through variants.
 * @method HasOneThrough highestPrice() Get the highest price relation through variants.
 * @method HasOne cheapestVariant() Get the cheapest variant relation.
 * @method HasOne mostExpensiveVariant() Get the most expensive variant relation.
 * @method HasManyDeep<ProductOptionValue, Product> variantValues() Get product option values relation through variants.
 */
class Product extends LunarProduct implements ProductContract
{
    use InteractsWithDystoreApi;
}
