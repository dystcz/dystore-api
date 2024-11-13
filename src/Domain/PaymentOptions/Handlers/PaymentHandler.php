<?php

namespace Dystore\Api\Domain\PaymentOptions\Handlers;

use Lunar\Models\Contracts\Cart as CartContract;

abstract class PaymentHandler
{
    public function handle(CartContract $cart): void {}
}
