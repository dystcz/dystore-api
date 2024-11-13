<?php

namespace Dystore\Api\Domain\Auth\Actions;

use Dystore\Api\Domain\Users\Models\User;
use Dystore\Api\Support\Actions\Action;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Str;

class CompletePasswordReset extends Action
{
    /**
     * Complete the password reset process for the given user.
     */
    public function handle(Guard $guard, User $user): void
    {
        /** @var User $user */
        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
    }
}
