<?php

namespace Dystore\Api\Domain\ProductVariants\Models;

use Dystore\Api\Base\Contracts\HasAvailability;
use Dystore\Api\Base\Contracts\Translatable;
use Dystore\Api\Domain\ProductVariants\Concerns\InteractsWithLunarApi;
use Dystore\Api\Domain\ProductVariants\Contracts\ProductVariant as ProductVariantContract;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Lunar\Models\ProductVariant as LunarPoductVariant;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @method MorphMany notifications() Get the notifications relation if `lunar-api-product-notifications` package is installed.
 * @method Media|null getThumbnail() Get either variant thumbnail or fallback to product thumbnail.
 * @method Collection getImages() Get either variant images or fallback to product images.
 */
class ProductVariant extends LunarPoductVariant implements HasAvailability, HasMedia, ProductVariantContract, Translatable
{
    use InteractsWithLunarApi;
}
