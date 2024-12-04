<?php

namespace Dystore\Api\Domain\Carts\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Carts\Contracts\CartPaymentOptionController as CartPaymentOptionControllerContract;
use Dystore\Api\Domain\Carts\Contracts\CurrentSessionCart;
use Dystore\Api\Domain\Carts\JsonApi\V1\SetPaymentOptionRequest;
use Dystore\Api\Domain\Carts\JsonApi\V1\UnsetPaymentOptionRequest;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\PaymentOptions\Facades\PaymentManifest;
use LaravelJsonApi\Core\Responses\DataResponse;

class CartPaymentOptionController extends Controller implements CartPaymentOptionControllerContract
{
    /**
     * Set payment option to cart.
     */
    public function setPaymentOption(
        SetPaymentOptionRequest $request,
        ?CurrentSessionCart $cart,
    ): DataResponse {
        /** @var Cart $cart */
        $this->authorize('updatePaymentOption', $cart);

        $option = PaymentManifest::getOption($cart, $request->input('data.attributes.payment_option'));

        $model = $cart->setPaymentOption($option);

        return DataResponse::make($model)
            ->didntCreate();
    }

    /**
     * Unset payment option from cart.
     */
    public function unsetPaymentOption(
        UnsetPaymentOptionRequest $request,
        ?CurrentSessionCart $cart,
    ): DataResponse {
        /** @var Cart $cart */
        $this->authorize('updatePaymentOption', $cart);

        $model = $cart->unsetPaymentOption();

        return DataResponse::make($model)
            ->didntCreate();
    }
}
