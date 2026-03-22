<?php

namespace Dystore\Api\Domain\Users\Actions;

use Dystore\Api\Domain\Users\Contracts\DeletesUser;
use Dystore\Api\Domain\Users\Contracts\User as UserContract;
use Dystore\Api\Domain\Users\Models\User;

class DeleteUser implements DeletesUser
{
    public function handle(UserContract $user): void
    {
        /** @var User $user */
        $user->delete();
    }
}
