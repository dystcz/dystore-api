<?php

namespace Dystore\Api\Domain\ShippingOptions\Http\Routing;

use Dystore\Api\Domain\ShippingOptions\Contracts\ShippingOptionsController;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class ShippingOptionRouteGroup extends RouteGroup
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $server->resource($this->getPrefix(), ShippingOptionsController::class)
                    ->only('index')
                    ->readOnly();
            });
    }
}
