<?php

namespace Dystore\Api\Domain\PaymentOptions\Http\Routing;

use Dystore\Api\Domain\PaymentOptions\Contracts\PaymentOptionsController;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class PaymentOptionRouteGroup extends RouteGroup
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $server->resource($this->getPrefix(), PaymentOptionsController::class)
                    ->only('index')
                    ->readOnly();
            });
    }
}
