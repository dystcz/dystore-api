<?php

namespace Dystore\Api\Domain\ProductVariants\Builders;

use Dystore\Api\Base\Enums\PurchasableStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Builder<Model>
 */
class ProductVariantBuilder extends Builder
{
    /**
     * Scope a query to only include always purchasable variants.
     */
    public function alwaysPurchasable(): self
    {
        return $this->where(
            $this->qualifyColumn('purchasable'),
            PurchasableStatus::ALWAYS->value,
        );
    }

    /**
     * Scope a query to only include in stock variants.
     */
    public function inStock(): self
    {
        return $this
            ->where($this->qualifyColumn('purchasable'), PurchasableStatus::IN_STOCK->value)
            ->where($this->qualifyColumn('stock'), '>', 0);
    }

    /**
     * Scope a query to only include backorderable variants.
     */
    public function backorderable(): self
    {
        return $this
            ->where($this->qualifyColumn('purchasable'), PurchasableStatus::BACKORDER->value)
            ->where($this->qualifyColumn('backorder'), '>', 0);
    }

    /**
     * Scope a query to only include available variants.
     *
     * A variant is available when it is always purchasable, in stock,
     * or backorderable.
     */
    public function available(): self
    {
        return $this->where(function (Builder $query) {
            /** @var ProductVariantBuilder $query */
            $query
                ->alwaysPurchasable()
                ->orWhere(fn (Builder $query) => $query
                    ->where($this->qualifyColumn('purchasable'), PurchasableStatus::IN_STOCK->value)
                    ->where($this->qualifyColumn('stock'), '>', 0))
                ->orWhere(fn (Builder $query) => $query
                    ->where($this->qualifyColumn('purchasable'), PurchasableStatus::BACKORDER->value)
                    ->where($this->qualifyColumn('backorder'), '>', 0));
        });
    }
}
