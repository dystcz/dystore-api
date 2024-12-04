<?php

namespace Dystore\Api\Domain\OrderLines\Factories;

use Dystore\Api\Domain\Orders\Models\Order;
use Lunar\Database\Factories\OrderLineFactory as LunarOrderLineFactory;

class OrderLineFactory extends LunarOrderLineFactory
{
    public function definition(): array
    {
        return [
            ...parent::definition(),

            'order_id' => Order::modelClass()::factory(),
        ];
    }
}
