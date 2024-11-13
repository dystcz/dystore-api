<?php

namespace Dystore\Api\Domain\Carts\Http\Routing;

use Dystore\Api\Domain\Carts\Contracts\CartCouponsController;
use Dystore\Api\Domain\Carts\Contracts\CartPaymentOptionController;
use Dystore\Api\Domain\Carts\Contracts\CartsController;
use Dystore\Api\Domain\Carts\Contracts\CheckoutCartController;
use Dystore\Api\Domain\Carts\Contracts\ClearUserCartController;
use Dystore\Api\Domain\Carts\Contracts\CreateEmptyCartAddressesController;
use Dystore\Api\Domain\Carts\Contracts\ReadUserCartController;
use Dystore\Api\Routing\RouteGroup;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ActionRegistrar;
use LaravelJsonApi\Laravel\Routing\Relationships;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

class CartRouteGroup extends RouteGroup
{
    /**
     * Register routes.
     */
    public function routes(): void
    {
        JsonApiRoute::server('v1')
            ->prefix('v1')
            ->resources(function (ResourceRegistrar $server) {
                $server->resource($this->getPrefix(), CartsController::class)
                    ->relationships(function (Relationships $relationships) {
                        $relationships->hasMany('cart_lines')->readOnly();
                        $relationships->hasMany('cart_addresses')->readOnly();
                        $relationships->hasOne('shipping_address')->readOnly();
                        $relationships->hasOne('billing_address')->readOnly();
                    })
                    ->only('show');

                $server->resource($this->getPrefix(), ClearUserCartController::class)
                    ->only('')
                    ->actions('-actions', function (ActionRegistrar $actions) {
                        $actions->delete('clear');
                    });

                $server->resource($this->getPrefix(), ReadUserCartController::class)
                    ->only('')
                    ->actions('-actions', function (ActionRegistrar $actions) {
                        $actions->get('my-cart');
                    });

                $server->resource($this->getPrefix(), CreateEmptyCartAddressesController::class)
                    ->only('')
                    ->actions('-actions', function (ActionRegistrar $actions) {
                        $actions->post('create-empty-addresses');
                    });

                $server->resource($this->getPrefix(), CheckoutCartController::class)
                    ->only('')
                    ->actions('-actions', function (ActionRegistrar $actions) {
                        $actions->post('checkout');
                    });

                $server->resource($this->getPrefix(), CartCouponsController::class)
                    ->only('')
                    ->actions('-actions', function (ActionRegistrar $actions) {
                        $actions->post('set-coupon');
                        $actions->post('unset-coupon');
                    });

                $server->resource($this->getPrefix(), CartPaymentOptionController::class)
                    ->only('')
                    ->actions('-actions', function (ActionRegistrar $actions) {
                        $actions->post('set-payment-option');
                        $actions->post('unset-payment-option');
                    });
            });
    }
}
