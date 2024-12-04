<?php

namespace Dystore\Api\Domain\Carts\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressSchema;
use Dystore\Api\Domain\Carts\Contracts\CartShippingOptionController as CartShippingOptionControllerContract;
use Dystore\Api\Domain\Carts\Contracts\CurrentSessionCart;
use Dystore\Api\Domain\Carts\JsonApi\V1\SetShippingOptionRequest;
use Dystore\Api\Domain\Carts\JsonApi\V1\UnsetShippingOptionRequest;
use Dystore\Api\Domain\Carts\Models\Cart;
use LaravelJsonApi\Core\Responses\DataResponse;

class CartShippingOptionController extends Controller implements CartShippingOptionControllerContract
{
    /**
     * Set shipping option to cart.
     */
    public function setShippingOption(
        CartAddressSchema $schema,
        SetShippingOptionRequest $request,
        ?CurrentSessionCart $cart,
    ): DataResponse {
        /** @var Cart $cart */
        $this->authorize('updateShippingOption', $cart);

        $cartAddress = $cart
            ->addresses()
            ->where('type', $request->input('data.attributes.address_type'))
            ->firstOrFail();

        // Set shipping option
        $cartAddress->update([
            'shipping_option' => $request->input('data.attributes.shipping_option'),
        ]);

        $model = $schema
            ->repository()
            ->queryOne($cartAddress)
            ->withRequest($request)
            ->first();

        return DataResponse::make($model)
            ->didntCreate();
    }

    /**
     * Unset shipping option from cart.
     */
    public function unsetShippingOption(
        CartAddressSchema $schema,
        UnsetShippingOptionRequest $request,
        ?CurrentSessionCart $cart,
    ): DataResponse {
        /** @var Cart $cart */
        $this->authorize('updateShippingOption', $cart);

        $cartAddress = $cart
            ->addresses()
            ->where('type', $request->input('data.attributes.address_type'))
            ->firstOrFail();

        // Unset shipping option
        $cartAddress->update([
            'shipping_option' => null,
        ]);

        $model = $schema
            ->repository()
            ->queryOne($cartAddress)
            ->withRequest($request)
            ->first();

        return DataResponse::make($model)
            ->didntCreate();
    }
}
