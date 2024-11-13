<?php

namespace Dystore\Api\Domain\Channels\Http\Routing;

use Dystore\Api\Domain\Channels\Contracts\ChannelsController;
use Dystore\Api\Routing\Contracts\RouteGroup as RouteGroupContract;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class ChannelRouteGroup extends RouteGroup implements RouteGroupContract
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $server->resource($this->getPrefix(), ChannelsController::class)
                    ->only('index', 'show')
                    ->readOnly();
            });
    }
}
