<?php

namespace Dystore\Api\Domain\Users\Http\Routing;

use Dystore\Api\Domain\Users\Contracts\ChangePasswordController;
use Dystore\Api\Domain\Users\Contracts\UsersController;
use Dystore\Api\Facades\LunarApi;
use Dystore\Api\Routing\Contracts\RouteGroup as RouteGroupContract;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ActionRegistrar;
use LaravelJsonApi\Laravel\Routing\Relationships;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class UserRouteGroup extends RouteGroup implements RouteGroupContract
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $authGuard = LunarApi::getAuthGuard();

                $server
                    ->resource('users', UsersController::class)
                    ->relationships(function (Relationships $relationships) {
                        $relationships->hasMany('customers')->readOnly();
                    })
                    ->only('store', 'update');

                $server
                    ->resource('users', ChangePasswordController::class)
                    ->only('')
                    ->actions('-actions', function (ActionRegistrar $actions) {
                        $actions
                            ->withId()
                            ->patch('change-password', 'update')
                            ->name('users.change-password');
                    })
                    ->middleware('auth:'.LunarApi::getAuthGuard());
            });
    }
}
