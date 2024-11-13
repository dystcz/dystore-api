<?php

namespace Dystore\Api\Domain\CartAddresses\Http\Routing;

use Dystore\Api\Domain\CartAddresses\Contracts\CartAddressesController;
use Dystore\Api\Domain\CartAddresses\Contracts\CartAddressShippingOptionController;
use Dystore\Api\Domain\CartAddresses\Contracts\ContinuousUpdateCartAddressController;
use Dystore\Api\Domain\CartAddresses\Contracts\UpdateCartAddressCountryController;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ActionRegistrar;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class CartAddressRouteGroup extends RouteGroup
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $server->resource($this->getPrefix(), CartAddressesController::class)
                    ->only('store', 'update');

                $server->resource($this->getPrefix(), CartAddressShippingOptionController::class)
                    ->only('')
                    ->actions('-actions', function (ActionRegistrar $actions) {
                        $actions->withId()->patch('set-shipping-option');
                        $actions->withId()->patch('unset-shipping-option');
                    });

                $server->resource($this->getPrefix(), UpdateCartAddressCountryController::class)
                    ->only('')
                    ->actions('-actions', function (ActionRegistrar $actions) {
                        $actions->withId()->patch('update-country');
                    });

                $server->resource($this->getPrefix(), ContinuousUpdateCartAddressController::class)
                    ->only('')
                    ->actions('-actions', function (ActionRegistrar $actions) {
                        $actions->withId()->patch('continuous-update');
                    });
            });
    }
}
