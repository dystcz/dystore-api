<?php

namespace Dystcz\LunarApi\Domain\ProductVariants\Concerns;

use Dystcz\LunarApi\Base\Enums\PurchasableStatus;
use Dystcz\LunarApi\Base\Traits\InteractsWithAvailability;
use Dystcz\LunarApi\Domain\Attributes\Traits\InteractsWithAttributes;
use Dystcz\LunarApi\Domain\Products\Models\Product;
use Dystcz\LunarApi\Domain\ProductVariants\Factories\ProductVariantFactory;
use Dystcz\LunarApi\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;
use Lunar\Base\Traits\HasUrls;
use Lunar\Models\Price as LunarPrice;
use Lunar\Models\ProductVariant as LunarPoductVariant;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait InteractsWithLunarApi
{
    use HashesRouteKey;
    use HasUrls;
    use InteractsWithAttributes;
    use InteractsWithAvailability;
    use InteractsWithMedia;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): ProductVariantFactory
    {
        return ProductVariantFactory::new();
    }

    /**
     * Determine when model is considered to be preorderable.
     */
    public function isPreorderable(): bool
    {
        /** @var Product $product */
        $product = $this->product;

        return $product->isPreorderable()
            && (
                $this->isAlwaysPurchasable()
                || $this->isInStock()
                || $this->isBackorderable()
            );
    }

    /**
     * In stock approximate quantity attribute.
     */
    public function approximateInStockQuantity(): Attribute
    {
        $threshold = Config::get('lunar-api.general.availability.approximate_in_stock_quantity.threshold', 5);

        if (Config::get('lunar-api.general.availability.display_real_quantity', false)) {
            return Attribute::make(
                get: fn () => $this->inStockQuantity
            );
        }

        $displayRealUnderThreshold = Config::get(
            'lunar-api.general.availability.approximate_in_stock_quantity.display_real_under_threshold',
            true,
        );

        return Attribute::make(
            get: fn () => match (true) {
                ($this->inStockQuantity > $threshold) => __(
                    'lunar-api::availability.stock.quantity_string.more_than',
                    ['quantity' => $threshold],
                ),
                ($this->inStockQuantity <= $threshold) && $displayRealUnderThreshold => $this->inStockQuantity,
                ($this->inStockQuantity <= $threshold) => __(
                    'lunar-api::availability.stock.quantity_string.less_than',
                    ['quantity' => $threshold],
                ),
                default => null,
            }
        );
    }

    /**
     * In stock quantity attribute.
     */
    public function inStockQuantity(): Attribute
    {
        return Attribute::make(
            get: fn () => match (true) {
                $this->purchasable === PurchasableStatus::BACKORDER => $this->backorder,
                default => $this->stock,
            }
        );
    }

    /**
     * Thumbnail relation.
     */
    public function thumbnail(): HasOneThrough
    {
        $prefix = Config::get('lunar.database.table_prefix');
        $table = "{$prefix}media_product_variant";

        return $this
            ->hasOneThrough(
                Media::class,
                ProductVariantMedia::class,
                'product_variant_id',
                'id',
                'id',
                'media_id'
            )
            ->where('primary', true);
    }

    /**
     * Lowest price relation.
     *
     * @throws InvalidArgumentException
     */
    public function lowestPrice(): MorphOne
    {
        return $this
            ->morphOne(
                LunarPrice::modelClass(),
                'priceable'
            )
            ->ofMany('price', 'min');
    }

    /**
     * Highest price relation.
     *
     * @throws InvalidArgumentException
     */
    public function highestPrice(): MorphOne
    {
        return $this
            ->morphOne(
                LunarPrice::modelClass(),
                'priceable'
            )
            ->ofMany('price', 'max');
    }

    /**
     * Other variants relation.
     */
    public function otherVariants(): HasMany
    {
        return $this
            ->hasMany(
                LunarPoductVariant::modelClass(),
                'product_id',
                'product_id',
            )
            ->where(
                $this->getRouteKeyName(),
                '!=',
                $this->getAttribute($this->getRouteKeyName()),
            );
    }
}
