<?php

namespace Dystore\Api\Domain\Products\Builders;

use DateTime;
use Dystore\Api\Domain\ProductVariants\Builders\ProductVariantBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Lunar\Models\Contracts\CustomerGroup as CustomerGroupContract;

/**
 * @method static ProductBuilder customerGroup(CustomerGroupContract|iterable|null $customerGroup = null, ?DateTime $startsAt = null, ?DateTime $endsAt = null)
 *
 * @extends Builder<Model>
 */
class ProductBuilder extends Builder
{
    /**
     * Scope a query to only include visible models.
     */
    public function visible(): self
    {
        return $this->published();
    }

    /**
     * Scope a query to only include published models.
     */
    public function published(): self
    {
        return $this->where('status', '!=', 'draft');
    }

    /**
     * Scope a query to only include products with always purchasable variants.
     */
    public function alwaysPurchasable(): self
    {
        /** @var ProductVariantBuilder $query */
        return $this->whereHas('variants', fn (Builder $query) => $query->alwaysPurchasable());
    }

    /**
     * Scope a query to only include products with in stock variants.
     */
    public function inStock(): self
    {
        /** @var ProductVariantBuilder $query */
        return $this->whereHas('variants', fn (Builder $query) => $query->inStock());
    }

    /**
     * Scope a query to only include products with backorderable variants.
     */
    public function backorderable(): self
    {
        /** @var ProductVariantBuilder $query */
        return $this->whereHas('variants', fn (Builder $query) => $query->backorderable());
    }

    /**
     * Scope a query to only include available products.
     *
     * A product is available when it has at least one variant that is
     * always purchasable, in stock, or backorderable.
     */
    public function available(): self
    {
        /** @var ProductVariantBuilder $query */
        return $this->whereHas('variants', fn (Builder $query) => $query->available());
    }
}
