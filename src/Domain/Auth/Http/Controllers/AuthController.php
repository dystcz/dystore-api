<?php

namespace Dystore\Api\Domain\Auth\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Auth\JsonApi\V1\LoginRequest;
use Dystore\Api\Domain\Users\Contracts\User as UserContract;
use Dystore\Api\Domain\Users\JsonApi\V1\UserQuery;
use Dystore\Api\Domain\Users\JsonApi\V1\UserSchema;
use Dystore\Api\Domain\Users\Models\User;
use Dystore\Api\Facades\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Responses\DataResponse;

class AuthController extends Controller
{
    /**
     * Get currently logged in User.
     */
    public function me(UserSchema $schema, Request $request, UserQuery $query, UserContract $user): DataResponse
    {
        /** @var User|null $user */
        $user = $request->user();

        /** @var Order $model */
        $model = $schema
            ->repository()
            ->queryOne($user)
            ->withRequest($request)
            ->first();

        return DataResponse::make($model)
            ->withQueryParameters($query)
            ->didntCreate();
    }

    /**
     * Log the user in.
     *
     * NOTE: Login attempt is in the request class
     */
    public function login(UserSchema $schema, LoginRequest $request, UserQuery $query, UserContract $user): DataResponse
    {
        /** @var User|null $user */
        $user = $request->user();

        /** @var Order $model */
        $model = $schema
            ->repository()
            ->queryOne($user)
            ->withRequest($request)
            ->first();

        return DataResponse::make($model)
            ->withQueryParameters($query)
            ->didntCreate();
    }

    /**
     * Log out logged in User.
     */
    public function logout(Request $request): DataResponse
    {
        Auth::guard(Api::getAuthGuard())->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return DataResponse::make(null);
    }
}
