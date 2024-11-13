<?php

namespace Dystore\Api\Tests\Feature\Domain\JsonApi\Extensions;

use Dystore\Api\Domain\JsonApi\Resources\JsonApiResource;

class ProductResourceMock extends JsonApiResource
{
    public function attributes($request): iterable
    {
        return parent::attributes($request);
    }

    public function relationships($request): iterable
    {
        return parent::relationships($request);
    }
}
