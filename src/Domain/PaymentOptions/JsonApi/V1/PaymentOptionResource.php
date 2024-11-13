<?php

namespace Dystore\Api\Domain\PaymentOptions\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Resources\JsonApiResource;
use Dystore\Api\Domain\PaymentOptions\Entities\PaymentOption;

class PaymentOptionResource extends JsonApiResource
{
    /**
     * {@inheritDoc}
     */
    public function id(): string
    {
        return $this->resource->getId();
    }

    /**
     * {@inheritDoc}
     */
    public function attributes($request): iterable
    {
        /** @var PaymentOption $option */
        $option = $this->resource;

        return $option->toArray();
    }
}
