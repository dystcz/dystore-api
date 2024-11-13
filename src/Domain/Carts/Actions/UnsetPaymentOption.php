<?php

namespace Dystore\Api\Domain\Carts\Actions;

use Dystore\Api\Domain\Carts\Models\Cart;
use Lunar\Actions\AbstractAction;
use Lunar\Models\Contracts\Cart as CartContract;

class UnsetPaymentOption extends AbstractAction
{
    /**
     * Unset payment option from cart.
     */
    public function execute(
        CartContract $cart
    ): self {
        /** @var Cart $cart */
        $cart->paymentOption = null;
        $cart->update([
            'payment_option' => null,
        ]);

        return $this;
    }
}
