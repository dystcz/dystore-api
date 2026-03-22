<?php

namespace Dystore\Api\Domain\Users\Contracts;

use Dystore\Api\Domain\Users\Contracts\User as UserContract;

interface DeletesUser
{
    public function handle(UserContract $user): void;
}
