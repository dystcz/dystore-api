<?php

namespace Dystcz\LunarApi;

use Dystcz\LunarApi\Domain\Carts\Contracts\CheckoutCart;
use Dystcz\LunarApi\Domain\Users\Contracts\CreatesNewUsers;
use Dystcz\LunarApi\Domain\Users\Contracts\CreatesUserFromCart;
use Dystcz\LunarApi\Domain\Users\Contracts\RegistersUser;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class LunarApi
{
    private string $root;

    public function __construct(string $root)
    {
        $this->root = $root;
    }

    /**
     * Get the root path of the package.
     */
    public function getPackageRoot(): string
    {
        return $this->root;
    }

    /**
     * Create new user using class.
     */
    public static function createUserUsing(string $class): void
    {
        App::singleton(CreatesNewUsers::class, $class);
    }

    /**
     * Create user from cart using class.
     */
    public static function createUserFromCartUsing(string $class): void
    {
        App::singleton(CreatesUserFromCart::class, $class);
    }

    /**
     * Register user using class.
     */
    public static function registerUserUsing(string $class): void
    {
        App::singleton(RegistersUser::class, $class);
    }

    /**
     * Checkout cart using class.
     */
    public static function checkoutCartUsing(string $class): void
    {
        App::singleton(CheckoutCart::class, $class);
    }

    /**
     * Check if hashids are used.
     */
    public static function usesHashids(): bool
    {
        return Config::get('lunar-api.general.use_hashids', false);
    }
}
