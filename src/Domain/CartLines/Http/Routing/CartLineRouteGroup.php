<?php

namespace Dystore\Api\Domain\CartLines\Http\Routing;

use Dystore\Api\Domain\CartLines\Contracts\CartLinesController;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class CartLineRouteGroup extends RouteGroup
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
                    ->resource($this->getPrefix(), CartLinesController::class)
                    ->only('update', 'destroy', 'store');
            });
    }
}
