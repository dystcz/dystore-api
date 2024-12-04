<?php

namespace Dystore\Api\Domain\Tags\Http\Routing;

use Dystore\Api\Domain\Tags\Contracts\TagsController;
use Dystore\Api\Routing\Contracts\RouteGroup as RouteGroupContract;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\Relationships;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class TagRouteGroup extends RouteGroup implements RouteGroupContract
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $server->resource($this->getPrefix(), TagsController::class)
                    ->relationships(function (Relationships $relationships) {
                        // $relationships->hasMany('taggables')->readOnly();
                    })
                    ->only('index', 'show')
                    ->readOnly();
            });
    }
}
