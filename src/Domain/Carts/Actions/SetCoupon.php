<?php

namespace Dystore\Api\Domain\Carts\Actions;

use Dystore\Api\Domain\Carts\Models\Cart;
use Illuminate\Support\Str;
use Lunar\Models\Contracts\Cart as CartContract;

class SetCoupon
{
    /**
     * Apply coupon.
     */
    public function __invoke(CartContract $cart, string $couponCode): CartContract
    {
        /** @var Cart $cart */
        $cart->coupon_code = Str::upper($couponCode);

        $cart->save();

        return $cart->calculate();
    }
}
