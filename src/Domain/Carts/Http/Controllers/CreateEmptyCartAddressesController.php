<?php

namespace Dystore\Api\Domain\Carts\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Carts\Actions\CreateEmptyCartAddresses;
use Dystore\Api\Domain\Carts\Contracts\CreateEmptyCartAddressesController as CreateEmptyCartAddressesControllerContract;
use Dystore\Api\Domain\Carts\Contracts\CurrentSessionCart;
use Dystore\Api\Domain\Carts\JsonApi\V1\CartQuery;
use Dystore\Api\Domain\Carts\JsonApi\V1\CartSchema;
use Dystore\Api\Domain\Carts\JsonApi\V1\CreateEmptyCartAddressesRequest;
use Dystore\Api\Domain\Carts\Models\Cart;
use LaravelJsonApi\Core\Responses\DataResponse;

class CreateEmptyCartAddressesController extends Controller implements CreateEmptyCartAddressesControllerContract
{
    /**
     * Update an existing resource.
     *
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\Response
     */
    public function createEmptyAddresses(
        CartSchema $schema,
        CreateEmptyCartAddressesRequest $request,
        CartQuery $query,
        CreateEmptyCartAddresses $createEmptyCartAddresses,
        ?CurrentSessionCart $cart,
    ): DataResponse {
        /** @var Cart $cart */
        $this->authorize('createEmptyAddresses', $cart);

        $createEmptyCartAddresses->handle($cart);

        $model = $schema
            ->repository()
            ->queryOne($cart)
            ->withRequest($request)
            ->first();

        return DataResponse::make($model)
            ->withQueryParameters($query)
            ->didntCreate();
    }
}
