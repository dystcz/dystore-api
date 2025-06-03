<?php

namespace Dystore\Api\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Contracts\Auth\Guard auth()
 * @method static \Dystore\Api\Api authGuard(string $guard)
 * @method static string getAuthGuard()
 * @method static \Dystore\Api\Api createUserUsing(string $class)
 * @method static \Dystore\Api\Api createUserFromCartUsing(string $class)
 * @method static \Dystore\Api\Api registerUserUsing(string $class)
 * @method static \Dystore\Api\Api checkoutCartUsing(string $class)
 * @method static \Dystore\Api\Api hashIds(bool $value)
 * @method static bool usesHashids()
 * @method static \Dystore\Api\Api routes()
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
