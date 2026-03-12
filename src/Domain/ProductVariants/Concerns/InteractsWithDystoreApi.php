<?php

namespace Dystore\Api\Domain\ProductVariants\Concerns;

use Dystore\Api\Base\Enums\PurchasableStatus;
use Dystore\Api\Base\Traits\InteractsWithAvailability;
use Dystore\Api\Domain\Attributes\Traits\InteractsWithAttributes;
use Dystore\Api\Domain\Products\Models\Product;
use Dystore\Api\Domain\ProductVariants\Builders\ProductVariantBuilder;
use Dystore\Api\Domain\ProductVariants\Factories\ProductVariantFactory;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariant;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariantMedia;
use Dystore\Api\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Lunar\Base\Traits\HasUrls;
use Lunar\Models\Price as LunarPrice;
use Lunar\Models\ProductVariant as LunarPoductVariant;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait InteractsWithDystoreApi
{
    use HashesRouteKey;
    use HasUrls;
    use InteractsWithAttributes;
    use InteractsWithAvailability;
    use InteractsWithMedia;

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  Builder  $query
     */
    public function newEloquentBuilder($query): ProductVariantBuilder
    {
        return new ProductVariantBuilder($query);
    }

    /**
     * Get the name attribute.
     */
    public function name(): Attribute
    {
        return Attribute::make(
            get: function () {
                /** @var ProductVariant $this */
                $productName = $this->product->translateAttribute('name');
                $variantName = $this->translateAttribute('name');

                if ($variantName === $productName) {
                    return $variantName;
                }

                if (Str::contains($variantName, $productName)) {
                    return Str::replace($productName, '', $variantName, false);
                }

                return implode(' ', array_filter([$this->product->attr('name'), $this->attr('name')]));
            }
        );
    }

    /**
     * Determine when model is considered to be preorderable.
     */
    public function isPreorderable(): ?bool
    {
        /** @var ProductVariant $model */
        $model = $this;

        if (! $model->relationLoaded('product')) {
            return null;
        }

        return $model->product->isPreorderable()
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
        $threshold = Config::get('dystore.general.availability.approximate_in_stock_quantity.threshold', 5);

        if (Config::get('dystore.general.availability.display_real_quantity', false)) {
            return Attribute::make(
                get: fn () => $this->inStockQuantity
            );
        }

        $displayRealUnderThreshold = Config::get(
            'dystore.general.availability.approximate_in_stock_quantity.display_real_under_threshold',
            true,
        );

        return Attribute::make(
            get: fn () => match (true) {
                ($this->inStockQuantity > $threshold) => __(
                    'dystore::availability.stock.quantity_string.more_than',
                    ['quantity' => $threshold],
                ),
                ($this->inStockQuantity <= $threshold) && $displayRealUnderThreshold => $this->inStockQuantity,
                ($this->inStockQuantity <= $threshold) => __(
                    'dystore::availability.stock.quantity_string.less_than',
                    ['quantity' => $threshold],
                ),
                default => null,
            }
        );
    }

    /**
     * Get either variant thumbnail or fallback to product thumbnail.
     */
    public function getThumbnail(): ?Media
    {
        return $this->thumbnail ?? $this->product->thumbnail;
    }

    /**
     * Get either variant images or fallback to product images.
     */
    public function getImages(): Collection
    {
        return $this->images->isNotEmpty()
            ? $this->images
            : $this->product->images;
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

    public function price(): MorphOne
    {
        return $this->lowestPrice();
    }

    public function lowestPrice(): MorphOne
    {
        /** @var ProductVariant $this */
        return $this
            ->morphOne(LunarPrice::modelClass(), 'priceable')
            ->ofMany('price', 'min');
    }

    public function highestPrice(): MorphOne
    {
        /** @var ProductVariant $this */
        return $this
            ->morphOne(LunarPrice::modelClass(), 'priceable')
            ->ofMany('price', 'max');
    }

    /**
     * Variants except the current one.
     */
    public function otherVariants(): HasMany
    {
        /** @var ProductVariant $this */
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

    public static function newFactory(): ProductVariantFactory
    {
        return ProductVariantFactory::new();
    }
}
