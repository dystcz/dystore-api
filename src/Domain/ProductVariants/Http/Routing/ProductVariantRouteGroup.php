<?php

namespace Dystore\Api\Domain\ProductVariants\Http\Routing;

use Dystore\Api\Domain\ProductVariants\Contracts\ProductVariantsController;
use Dystore\Api\Routing\Contracts\RouteGroup as RouteGroupContract;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\Relationships;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class ProductVariantRouteGroup extends RouteGroup implements RouteGroupContract
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
                    ->resource($this->getPrefix(), ProductVariantsController::class)
                    ->relationships(function (Relationships $relationships) {
                        $relationships->hasOne('default_url')->readOnly();
                        $relationships->hasMany('images')->readOnly();
                        $relationships->hasMany('other_product_variants')->readOnly();
                        $relationships->hasMany('prices')->readOnly();
                        $relationships->hasOne('lowest_price')->readOnly();
                        $relationships->hasOne('highest_price')->readOnly();
                        $relationships->hasMany('product')->readOnly();
                        $relationships->hasOne('thumbnail')->readOnly();
                        $relationships->hasMany('urls')->readOnly();
                        $relationships->hasMany('product_option_values')->readOnly();
                    })
                    ->only('index', 'show')
                    ->readOnly();
            });
    }
}
