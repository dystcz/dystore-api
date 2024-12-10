<?php

namespace Dystore\Api\Domain\Storefront\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Resources\JsonApiResource;

class StorefrontResource extends JsonApiResource
{
    public function id(): string
    {
        /** @var \Dystore\Api\Domain\Storefront\Entities\Storefront $resource */
        $resource = $this->resource;

        return $resource->getSlug();
    }

    /**
     * Get the resource's attributes.
     *
     * @param  Request|null  $request
     */
    public function attributes($request): iterable
    {
        return [
            'slug' => $this->resource->getSlug(),
        ];
    }

    /**
     * Get the resource's relationships.
     *
     * @param  Request|null  $request
     */
    public function relationships($request): iterable
    {
        /** @var \Dystore\Api\Domain\Storefront\Entities\Storefront $resource */
        $resource = $this->resource;

        return [
            $this->relation('channel')->withData($resource->getChannel()),
            $this->relation('customer')->withData($resource->getCustomer()),
            $this->relation('currency')->withData($resource->getCurrency()),
            $this->relation('customer_groups')->withData($resource->getCustomerGroups()),
        ];
    }
}
