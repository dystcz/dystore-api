<?php

namespace Dystore\Api\Domain\Auth\Actions;

use Dystore\Api\Domain\Users\Contracts\User as UserContract;
use Dystore\Api\Domain\Users\Models\User;
use Dystore\Api\Support\Actions\Action;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Action
{
    /**
     * Reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     */
    public function handle(UserContract $user, array $input): void
    {
        /** @var User $user */
        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
