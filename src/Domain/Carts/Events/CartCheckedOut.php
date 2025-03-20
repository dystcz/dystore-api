<?php

namespace Dystore\Api\Domain\Carts\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Lunar\Models\Contracts\Cart as CartContract;
use Lunar\Models\Contracts\Order as OrderContract;

class CartCheckedOut
{
    use Dispatchable;

    public function __construct(
        public CartContract $cart,
        public OrderContract $order,
    ) {}
}
