<?php

namespace Dystcz\LunarApi\Domain\Carts\Actions;

use Dystcz\LunarApi\Domain\Carts\Models\Cart;
use Dystcz\LunarApi\Support\Actions\Action;

class CreateEmptyCartAddresses extends Action
{
    public function __construct() {}

    /**
     * Create empty addresses for a cart.
     */
    public function handle(Cart $cart): void
    {
        $cart->setShippingAddress([
            'country_id' => null,
            'title' => null,
            'first_name' => null,
            'last_name' => null,
            'company_name' => null,
            'line_one' => null,
            'line_two' => null,
            'line_three' => null,
            'city' => null,
            'state' => null,
            'postcode' => null,
            'delivery_instructions' => null,
            'contact_email' => null,
            'contact_phone' => null,
            'meta' => null,
        ]);

        $cart->setBillingAddress([
            'country_id' => null,
            'title' => null,
            'first_name' => null,
            'last_name' => null,
            'company_name' => null,
            'line_one' => null,
            'line_two' => null,
            'line_three' => null,
            'city' => null,
            'state' => null,
            'postcode' => null,
            'delivery_instructions' => null,
            'contact_email' => null,
            'contact_phone' => null,
            'meta' => null,
        ]);
    }
}
