<?php

namespace Dystore\Api\Domain\Storefront\Http\Routing;

use Dystore\Api\Domain\Storefront\Contracts\StorefrontController;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\Relationships;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class StorefrontRouteGroup extends RouteGroup
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $server->resource($this->getPrefix(), StorefrontController::class)
                    ->only(
                        'index',
                        'show',
                        'destroy',
                        'showRelated',
                        'updateRelationship',
                    )
                    ->relationships(function (Relationships $relations) {
                        $relations->hasOne('customer');
                        $relations->hasOne('channel');
                        $relations->hasOne('currency');
                        $relations->hasMany('customer_groups');
                    });
            });
    }
}
