<?php

namespace Dystcz\LunarApi\Domain\ProductVariants\Models;

use Dystcz\LunarApi\Base\Contracts\HasAvailability;
use Dystcz\LunarApi\Base\Contracts\Translatable;
use Dystcz\LunarApi\Domain\ProductVariants\Concerns\InteractsWithLunarApi;
use Dystcz\LunarApi\Domain\ProductVariants\Contracts\ProductVariant as ProductVariantContract;
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
