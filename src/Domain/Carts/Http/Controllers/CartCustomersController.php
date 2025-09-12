<?php

namespace Dystore\Api\Domain\Carts\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Carts\Contracts\CartCustomersController as CartCustomersControllerContract;
use Dystore\Api\Domain\Carts\Contracts\CurrentSessionCart;
use Dystore\Api\Domain\Carts\JsonApi\V1\CartRequest;
use Dystore\Api\Domain\Carts\JsonApi\V1\CartSchema;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\Customers\JsonApi\V1\CustomerQuery;
use LaravelJsonApi\Core\Responses\RelationshipResponse;
use Lunar\Facades\StorefrontSession;

class CartCustomersController extends Controller implements CartCustomersControllerContract
{
    public function setCustomer(
        CartSchema $schema,
        CartRequest $request,
        CustomerQuery $query,
        ?CurrentSessionCart $cart
    ): RelationshipResponse {
        /** @var Cart $cart */
        $this->authorize('updateCustomerRelationship', $cart);

        $customer = $schema
            ->repository()
            ->modifyToOne($cart, 'customer')
            ->withRequest($query)
            ->associate($request->validated('customer'));

        StorefrontSession::setCustomerGroups($customer->customerGroups);

        $cart->setCustomer($customer);

        return new RelationshipResponse($cart, 'customer', $customer);
    }
}
