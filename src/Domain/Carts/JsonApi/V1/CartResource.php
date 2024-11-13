<?php

namespace Dystore\Api\Domain\Carts\JsonApi\V1;

use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\JsonApi\Resources\JsonApiResource;
use Illuminate\Http\Request;

class CartResource extends JsonApiResource
{
    /**
     * Get the resource's attributes.
     *
     * @param  Request|null  $request
     */
    public function attributes($request): iterable
    {
        /** @var Cart $model */
        $model = $this->resource;

        if ($model->relationLoaded('lines')) {
            $model->calculate();
        }

        return parent::attributes($request);
    }
}
