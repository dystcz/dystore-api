<?php

namespace Dystore\Api\Domain\CartLines\Factories;

use Dystore\Api\Domain\Carts\Models\Cart;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Lunar\Database\Factories\CartLineFactory as LunarCartLineFactory;

/**
 * @extends Factory<Model>
 */
class CartLineFactory extends LunarCartLineFactory
{
    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'quantity' => $this->faker->numberBetween(0, 100),
            'purchasable_type' => ProductVariant::class,
            'purchasable_id' => 1,
            'meta' => null,
        ];
    }
}
