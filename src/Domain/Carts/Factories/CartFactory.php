<?php

namespace Dystore\Api\Domain\Carts\Factories;

use Dystore\Api\Domain\CartAddresses\Models\CartAddress;
use Dystore\Api\Domain\CartLines\Models\CartLine;
use Dystore\Api\Domain\Currencies\Models\Currency;
use Dystore\Api\Domain\Products\Models\Product;
use Dystore\Api\Domain\ProductVariants\Models\ProductVariant;
use Lunar\Models\Channel;

class CartFactory extends \Lunar\Database\Factories\CartFactory
{
    public function withAddresses(array $shippingParams = [], array $billingParams = []): static
    {
        return $this
            ->has(
                CartAddress::modelClass()::factory()->state(array_merge([
                    'type' => 'shipping',
                    'shipping_option' => 'FFCDEL',
                ], $shippingParams)),
                'addresses'
            )
            ->has(
                CartAddress::modelClass()::factory()->state(array_merge([
                    'type' => 'billing',
                ], $billingParams)),
                'addresses'
            );
    }

    public function withLines(int $count = 1): static
    {
        return $this->has(
            CartLine::modelClass()::factory()
                ->for(
                    ProductVariant::modelClass()::factory()->for(Product::modelClass()::factory())->withPrice(),
                    'purchasable'
                )
                ->count($count),
            'lines'
        );
    }

    public function definition(): array
    {
        return [
            'user_id' => null,
            'merged_id' => null,
            'currency_id' => Currency::modelClass()::getDefault() ?? Currency::modelClass()::factory(),
            'channel_id' => Channel::factory(),
            'coupon_code' => null,
            'completed_at' => null,
            'meta' => [],
        ];
    }
}
