<?php

namespace Dystore\Api\Domain\ProductVariants\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Resources\JsonApiResource;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantResource extends JsonApiResource
{
    /**
     * Get the resource's attributes.
     *
     * @param  Request|null  $request
     */
    public function attributes($request): iterable
    {
        /** @var ProductVariant */
        $model = $this->resource;

        if ($model->relationLoaded('highestPrice') && $model->relationLoaded('variants')) {
            $model->highestPrice->setRelation('priceable', $model);
        }

        if ($model->relationLoaded('lowestPrice')) {
            $model->lowestPrice->setRelation('priceable', $model);
        }

        if ($model->relationLoaded('prices')) {
            $model->prices->each(fn ($price) => $price->setRelation('priceable', $model));
        }

        if ($model->relationLoaded('basePrices')) {
            $model->prices->each(fn ($price) => $price->setRelation('priceable', $model));
        }

        return parent::attributes($request);
    }
}
