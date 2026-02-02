<?php

namespace Dystore\Api\Domain\Orders\Concerns;

use Dystore\Api\Domain\Orders\Factories\OrderFactory;
use Dystore\Api\Domain\PaymentOptions\Casts\PaymentBreakdown;
use Dystore\Api\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Lunar\Base\Casts\Price;
use Lunar\Models\Transaction;

trait InteractsWithDystoreApi
{
    use HashesRouteKey;

    public function getSelfLinkSignature(): ?string
    {
        $signedUrl = URL::signedRoute(
            name: 'v1.orders.show',
            parameters: ['order' => $this->getRouteKey()],
            absolute: false,
        );

        $signature = null;

        $query = (string) parse_url($signedUrl, PHP_URL_QUERY);
        if ($query !== '') {
            /** @var array<string, mixed> $params */
            parse_str($query, $params);
            $signature = is_string($params['signature'] ?? null) ? $params['signature'] : null;
        }

        return $signature;
    }

    /**
     * Attribute activity log blacklist.
     *
     * @return string[]
     */
    public static function getDefaultLogExcept(): array
    {
        return [
            ...parent::getDefaultLogExcept(),

            // WARNING: Because of: https://github.com/lunarphp/lunar/commit/e25b7bcef152a94e45251803e80f682d92424f28
            // NOTICE  Object of class Lunar\DataTypes\Price could not be converted to int in vendor/spatie/laravel-activitylog/src/Traits/LogsActivity.php on line 313.
            'payment_total',
            'payment_breakdown',
        ];
    }

    /**
     * Return product lines relationship.
     */
    public function productLines(): HasMany
    {
        /** @var \Lunar\Models\Order $this */
        return $this
            ->lines()
            ->whereNotIn(
                'type',
                Config::get('dystore.general.purchasable.non_eloquent_types', []),
            );
    }

    /**
     * Return payment lines relationship.
     */
    public function paymentLines(): HasMany
    {
        /** @var \Lunar\Models\Order $this */
        return $this->lines()->where('type', 'payment');
    }

    /**
     * Get the latest transaction for the order.
     */
    public function latestTransaction(): HasOne
    {
        /** @var \Lunar\Models\Order $this */
        return $this
            ->hasOne(Transaction::modelClass())
            ->latestOfMany();
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): OrderFactory
    {
        return OrderFactory::new();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string,string>
     */
    protected function casts(): array
    {
        /** @var \Lunar\Models\Order $this */
        return [
            ...$this->casts,
            ...parent::casts(),
            'payment_total' => Price::class,
            'payment_breakdown' => PaymentBreakdown::class,
        ];
    }
}
