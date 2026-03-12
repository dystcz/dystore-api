<?php

namespace Dystore\Api\Domain\Auth\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Auth\Contracts\CheckExistingAccountController as CheckExistingAccountControllerContract;
use Dystore\Api\Domain\Auth\JsonApi\V1\CheckExistingAccountRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;

class CheckExistingAccountController extends Controller implements CheckExistingAccountControllerContract
{
    /**
     * Register a user without a password.
     */
    public function checkExistingAccount(CheckExistingAccountRequest $request): JsonResponse
    {
        $model = Config::get('auth.providers.users.model');

        $exists = $model::query()
            ->where('email', $request->validated('email'))
            ->exists();

        return new JsonResponse([
            'exists' => $exists,
        ]);
    }
}
