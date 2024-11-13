<?php

namespace Dystore\Api\Domain\CartAddresses\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\CartAddresses\Contracts\CartAddressShippingOptionController as CartAddressShippingOptionControllerContract;
use Dystore\Api\Domain\CartAddresses\JsonApi\V1\CartAddressSchema;
use Dystore\Api\Domain\ShippingOptions\JsonApi\V1\SetShippingOptionRequest;
use Dystore\Api\Domain\ShippingOptions\JsonApi\V1\UnsetShippingOptionRequest;
use LaravelJsonApi\Core\Responses\DataResponse;
use Lunar\Models\Contracts\CartAddress as CartAddressContract;

class CartAddressShippingOptionController extends Controller implements CartAddressShippingOptionControllerContract
{
    /*
    * Set shipping option to cart shipping address.
    */
    public function setShippingOption(
        CartAddressSchema $schema,
        SetShippingOptionRequest $request,
        CartAddressContract $cartAddress,
    ): DataResponse {
        $this->authorize('update', $cartAddress);

        // Set shipping option
        $cartAddress->update([
            'shipping_option' => $request->input('data.attributes.shipping_option'),
        ]);

        $model = $schema
            ->repository()
            ->queryOne($cartAddress)
            ->withRequest($request)
            ->first();

        return DataResponse::make($model)->didntCreate();
    }

    /*
    * Unset shipping option from cart shipping address.
    */
    public function unsetShippingOption(
        CartAddressSchema $schema,
        UnsetShippingOptionRequest $request,
        CartAddressContract $cartAddress,
    ): DataResponse {
        $this->authorize('update', $cartAddress);

        // Unset shipping option
        $cartAddress->update(['shipping_option' => null]);

        $model = $schema
            ->repository()
            ->queryOne($cartAddress)
            ->withRequest($request)
            ->first();

        return DataResponse::make($model)->didntCreate();
    }
}
