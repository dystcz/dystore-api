<?php

namespace Dystore\Api\Domain\CustomerGroups\Http\Routing;

use Dystore\Api\Domain\CustomerGroups\Contracts\CustomerGroupsController;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\Relationships;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class CustomerGroupRouteGroup extends RouteGroup
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $server->resource($this->getPrefix(), CustomerGroupsController::class)
                    ->relationships(function (Relationships $relationships) {
                        //
                    })
                    ->readOnly()
                    ->only('show');
            });
    }
}
