<?php

namespace Dystore\Api\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard guard(string|null $name = null)
 * @method static \Dystore\Api\LunarApi authGuard(string $name) Set the auth guard
 * @method static string getAuthGuard() Get the auth guard
 * @method static \Dystore\Api\LunarApi createUserUsing(class-string $class)
 * @method static \Dystore\Api\LunarApi createUserFromCartUsing(class-string $class)
 * @method static \Dystore\Api\LunarApi registerUserUsing(class-string $class)
 * @method static \Dystore\Api\LunarApi checkoutCartUsing(class-string $class)
 * @method static \Dystore\Api\LunarApi hashIds(bool $value) Set ID hashing
 * @method static bool usesHashids() Check if the API hashes resource IDs
 *
 * @see \Dystore\Api\LunarApi
 */
class Api extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'lunar-api';
    }
}
