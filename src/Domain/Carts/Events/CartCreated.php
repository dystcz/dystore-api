<?php

namespace Dystore\Api\Domain\Carts\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Lunar\Models\Contracts\Cart as CartContract;

class CartCreated
{
    use Dispatchable;

    public function __construct(public CartContract $cart)
    {
        //
    }
}
