<?php

namespace Dystore\Api\Domain\ShippingOptions\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Resources\JsonApiResource;
use Dystore\Api\Domain\ShippingOptions\Entities\ShippingOption;

class ShippingOptionResource extends JsonApiResource
{
    public function id(): string
    {
        return $this->resource->getId();
    }

    public function attributes($request): iterable
    {
        /** @var ShippingOption $option */
        $option = $this->resource;

        return $option->toArray();
    }
}
