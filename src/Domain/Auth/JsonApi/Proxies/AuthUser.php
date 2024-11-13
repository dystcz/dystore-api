<?php

namespace Dystore\Api\Domain\Auth\JsonApi\Proxies;

use Dystore\Api\Domain\Users\Models\User;
use LaravelJsonApi\Eloquent\Proxy;

class AuthUser extends Proxy
{
    /**
     * UserAccount constructor.
     */
    public function __construct(?User $user = null)
    {
        parent::__construct($user ?: new User);
    }
}
