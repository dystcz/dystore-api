<?php

namespace Dystore\Api\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard guard(string|null $name = null)
 * @method static \Dystore\Api\Api authGuard(string $name) Set the auth guard
 * @method static string getAuthGuard() Get the auth guard
 * @method static \Dystore\Api\Api createUserUsing(class-string $class)
 * @method static \Dystore\Api\Api createUserFromCartUsing(class-string $class)
 * @method static \Dystore\Api\Api registerUserUsing(class-string $class)
 * @method static \Dystore\Api\Api checkoutCartUsing(class-string $class)
 * @method static \Dystore\Api\Api hashIds(bool $value) Set ID hashing
 * @method static bool usesHashids() Check if the API hashes resource IDs
 *
 * @see \Dystore\Api\Api
 */
class Api extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'dystore';
    }
}
