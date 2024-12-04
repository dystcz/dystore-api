<?php

namespace Dystore\Api\Domain\Currencies\Http\Routing;

use Dystore\Api\Domain\Currencies\Contracts\CurrenciesController;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class CurrencyRouteGroup extends RouteGroup
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $server->resource($this->getPrefix(), CurrenciesController::class)
                    ->only('index')
                    ->readOnly();
            });
    }
}
