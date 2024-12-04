<?php

namespace Dystore\Api\Domain\Users\Http\Controllers;

use Dystore\Api\Base\Controller;
use Dystore\Api\Domain\Users\Contracts\ChangePasswordController as ChangePasswordControllerContract;
use Dystore\Api\Domain\Users\Contracts\User as UserContract;
use Dystore\Api\Domain\Users\JsonApi\V1\ChangePasswordRequest;
use Dystore\Api\Domain\Users\JsonApi\V1\UserSchema;
use Dystore\Api\Domain\Users\Models\User;
use Illuminate\Support\Facades\Hash;
use LaravelJsonApi\Core\Responses\DataResponse;

class ChangePasswordController extends Controller implements ChangePasswordControllerContract
{
    public function update(
        UserSchema $schema,
        ChangePasswordRequest $request,
        UserContract $user,
    ): DataResponse {
        /** @var User $user */
        $this->authorize('update', $user);

        $user->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        $model = $schema
            ->repository()
            ->queryOne($user)
            ->withRequest($request)
            ->first();

        return DataResponse::make($model)
            ->didntCreate();
    }
}
