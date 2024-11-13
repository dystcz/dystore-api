<?php

namespace Dystore\Api\Domain\Auth\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Auth\Contracts\RegisterUserWithoutPasswordController as RegisterUserWithoutPasswordControllerContract;
use Dystore\Api\Domain\Auth\JsonApi\V1\UserWithoutPasswordRequest;
use Dystore\Api\Domain\Users\Contracts\RegistersUser;
use Dystore\Api\Domain\Users\Data\UserData;
use LaravelJsonApi\Core\Responses\DataResponse;

class RegisterUserWithoutPasswordController extends Controller implements RegisterUserWithoutPasswordControllerContract
{
    public function __construct(
        protected RegistersUser $registerUser,
    ) {}

    /**
     * Register a user without a password.
     */
    public function registerWithoutPassword(
        UserWithoutPasswordRequest $request,
    ): DataResponse {
        $user = $this->registerUser->register(
            new UserData(
                name: $request->validated('name'),
                email: $request->validated('email')
            )
        );

        return DataResponse::make($user)
            ->didCreate();
    }
}
