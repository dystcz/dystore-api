<?php

namespace Dystcz\LunarApi\Domain\Prices\JsonApi\V1;

use LaravelJsonApi\Core\Resources\JsonApiResource;
use Lunar\Models\Price;

class PriceResource extends JsonApiResource
{
    /**
     * Get the resource's attributes.
     *
     * @param \Illuminate\Http\Request|null $request
     * @return iterable
     */
    public function attributes($request): iterable
    {
        /** @var Price */
        $model = $this->resource;

        return [
            'price' => $model->price->formatted(),
            'price_decimal' => $model->price->decimal,
            'price_value' => $model->price->value,
            'compare_price' => $model->compare_price->value > $model->price->value ? $model->compare_price->formatted() : null,
        ];
    }

    /**
     * Get the resource's relationships.
     *
     * @param \Illuminate\Http\Request|null $request
     * @return iterable
     */
    public function relationships($request): iterable
    {
        return [];
    }
}