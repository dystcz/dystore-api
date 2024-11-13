<?php

namespace Dystore\Api\Domain\ProductOptionValues\Http\Routing;

use Dystore\Api\Domain\ProductOptionValues\Contracts\ProductOptionValuesController;
use Dystore\Api\Routing\Contracts\RouteGroup as RouteGroupContract;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class ProductOptionValueRouteGroup extends RouteGroup implements RouteGroupContract
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $server
                    ->resource($this->getPrefix(), ProductOptionValuesController::class)
                    ->readOnly();
            });
    }
}
