<?php

namespace Dystore\Api\Domain\Auth\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Auth\Contracts\AuthUserOrdersController as AuthUserOrdersControllerContract;
use Dystore\Api\Domain\Users\JsonApi\V1\UserSchema;
use Dystore\Api\Domain\Users\Models\User;
use LaravelJsonApi\Core\Responses\RelatedResponse;
use LaravelJsonApi\Laravel\Http\Requests\ResourceQuery;

class AuthUserOrdersController extends Controller implements AuthUserOrdersControllerContract
{
    /**
     * Get logged in User's Orders.
     */
    public function index(UserSchema $schema, ResourceQuery $request): RelatedResponse
    {
        /** @var User $user */
        $user = $request->user();

        $orders = $schema
            ->repository()
            ->queryToMany($user, 'orders')
            ->withRequest($request)
            ->getOrPaginate($request->page());

        return RelatedResponse::make($user, 'orders', $orders)
            ->withQueryParameters($request);
    }
}
