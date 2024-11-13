<?php

namespace Dystore\Api\Domain\Carts\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Carts\Actions\SetCoupon;
use Dystore\Api\Domain\Carts\Actions\UnsetCoupon;
use Dystore\Api\Domain\Carts\Contracts\CartCouponsController as CartCouponsControllerContract;
use Dystore\Api\Domain\Carts\Contracts\CurrentSessionCart;
use Dystore\Api\Domain\Carts\JsonApi\V1\SetCouponToCartRequest;
use Dystore\Api\Domain\Carts\Models\Cart;
use LaravelJsonApi\Core\Responses\DataResponse;

class CartCouponsController extends Controller implements CartCouponsControllerContract
{
    /**
     * Set coupon to cart.
     */
    public function setCoupon(
        SetCouponToCartRequest $request,
        SetCoupon $setCoupon,
        ?CurrentSessionCart $cart
    ): DataResponse {
        /** @var Cart $cart */
        $this->authorize('updateCoupon', $cart);

        $cart = $setCoupon($cart, $request->validated('coupon_code'));

        return DataResponse::make($cart)
            ->didntCreate();
    }

    /**
     * Unset coupon from cart.
     */
    public function unsetCoupon(
        UnsetCoupon $unsetCoupon,
        ?CurrentSessionCart $cart
    ): DataResponse {
        /** @var Cart $cart */
        $this->authorize('updateCoupon', $cart);

        $cart = $unsetCoupon($cart);

        return DataResponse::make($cart)
            ->didntCreate();
    }
}
