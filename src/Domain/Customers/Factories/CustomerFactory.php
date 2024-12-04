<?php

namespace Dystore\Api\Domain\Customers\Factories;

use Dystore\Api\Domain\OrderLines\Models\OrderLine;
use Dystore\Api\Domain\Orders\Models\Order;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariant;

class CustomerFactory extends \Lunar\Database\Factories\CustomerFactory
{
    public function withOrder(): static
    {
        return $this->has(
            Order::factory()
                ->has(
                    OrderLine::factory()
                        ->for(ProductVariant::factory()->withPrice(), 'purchasable'),
                    'lines'
                )
        );
    }
}
