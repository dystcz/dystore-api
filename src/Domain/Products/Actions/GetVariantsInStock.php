<?php

namespace Dystore\Api\Domain\Products\Actions;

use Dystore\Api\Domain\Products\Enums\Availability;
use Dystore\Api\Domain\Products\Models\Product;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariant;
use Illuminate\Support\Collection;
use Lunar\Models\Contracts\Product as ProductContract;
use Lunar\Models\Contracts\ProductVariant as ProductVariantContract;

class GetVariantsInStock
{
    /**
     * Get variants of the product that are in stock.
     */
    public function __invoke(ProductContract $product): Collection
    {
        /** @var Product $product */
        return $product->variants->filter(function (ProductVariantContract $variant) {
            /** @var ProductVariant $variant */
            return Availability::of($variant) !== Availability::OUT_OF_STOCK;
        });
    }
}
