<?php

namespace Dystore\Api\Domain\Carts\Actions;

use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\PaymentOptions\Entities\PaymentOption;
use Lunar\Actions\AbstractAction;
use Lunar\Models\Contracts\Cart as CartContract;

class SetPaymentOption extends AbstractAction
{
    /**
     * Set payment option for the cart.
     */
    public function execute(
        CartContract $cart,
        PaymentOption $paymentOption
    ): self {
        /** @var Cart $cart */
        $cart->paymentOption = $paymentOption;
        $cart->update([
            'payment_option' => $paymentOption->getIdentifier(),
        ]);

        return $this;
    }
}
