<?php

namespace Dystore\Api\Domain\Storefront\Capabilities;

use Dystore\Api\Domain\Storefront\Entities\Storefront;
use Dystore\Api\Domain\Storefront\Entities\StorefrontStorage;
use LaravelJsonApi\NonEloquent\Capabilities\CrudResource;

class CrudStorefront extends CrudResource
{
    public function __construct(private StorefrontStorage $storage)
    {
        parent::__construct();
    }

    public function read(Storefront $storefront): ?Storefront
    {
        return $storefront;
    }

    public function delete(Storefront $storefront): void
    {
        $this->storage->remove($storefront);
    }
}
