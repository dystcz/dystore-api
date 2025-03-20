<?php

namespace Dystore\Api\Domain\ProductVariants\Models;

use Dystore\Api\Base\Contracts\HasAvailability;
use Dystore\Api\Base\Contracts\Translatable;
use Dystore\Api\Domain\ProductVariants\Builders\ProductVariantBuilder;
use Dystore\Api\Domain\ProductVariants\Concerns\InteractsWithDystoreApi;
use Dystore\Api\Domain\ProductVariants\Contracts\ProductVariant as ProductVariantContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;
use Lunar\Models\ProductVariant as LunarPoductVariant;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @method static ProductVariantBuilder query()
 * @method bool isPreorderable() Determine when model is considered to be preorderable.
 * @method MorphMany notifications() Get the notifications relation if `dystore-product-notifications` package is installed.
 * @method Media|null getThumbnail() Get either variant thumbnail or fallback to product thumbnail.
 * @method Collection getImages() Get either variant images or fallback to product images.
 * @method HasOneThrough thumbnail() Get the thumbnail relation.
 * @method MorphOne lowestPrice() Get the lowest price relation.
 * @method MorphOne highestPrice() Get the highest price relation.
 * @method HasMany otherVariants() Get the other variants relation.
 *
 * @param  string|null  $approximateInStockQuantity
 * @param  int  $inStockQuantity
 */
class ProductVariant extends LunarPoductVariant implements HasAvailability, HasMedia, ProductVariantContract, Translatable
{
    use InteractsWithDystoreApi;
}
