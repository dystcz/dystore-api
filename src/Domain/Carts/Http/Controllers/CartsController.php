<?php

namespace Dystore\Api\Domain\Carts\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Carts\Contracts\CartsController as CartsControllerContract;
use Dystore\Api\Domain\Carts\JsonApi\V1\CartRequest;
use Dystore\Api\Domain\Carts\JsonApi\V1\CartSchema;
use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\Customers\JsonApi\V1\CustomerQuery;
use LaravelJsonApi\Core\Responses\RelationshipResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchOne;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelated;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\FetchRelationship;
use LaravelJsonApi\Laravel\Http\Controllers\Actions\UpdateRelationship;

class CartsController extends Controller implements CartsControllerContract
{
    use FetchOne;
    use FetchRelated;
    use FetchRelationship;
    use UpdateRelationship;

    public function updateCustomer(
        CartSchema $schema,
        CartRequest $request,
        CustomerQuery $query,
        Cart $cart
    ): RelationshipResponse {
        $customer = $schema
            ->repository()
            ->modifyToOne($cart, 'customer')
            ->withRequest($query)
            ->associate($request->validatedForRelation());

        $cart->setCustomer($customer);

        return new RelationshipResponse($cart, 'customer', $customer);
    }
}
