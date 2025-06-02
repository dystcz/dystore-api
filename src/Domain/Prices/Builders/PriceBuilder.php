<?php

namespace Dystore\Api\Domain\Prices\Builders;

use Illuminate\Contracts\Database\Query\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Lunar\Base\StorefrontSessionInterface;
use Lunar\Models\Contracts\CustomerGroup as CustomerGroupContract;
use Lunar\Models\Price;

/**
 * @extends Builder<Model>
 */
class PriceBuilder extends Builder
{
    public static function getStorefrontSession(): StorefrontSessionInterface
    {
        return App::make(StorefrontSessionInterface::class);
    }

    public static function scopeCurrency(BuilderContract $query, string $column = 'currency_id', ?string $table = null): void
    {
        $table = $table ?? (new Price)->getModel()->getTable();

        /** @var PriceBuilder $query */
        $query->where(
            "{$table}.{$column}",
            static::getStorefrontSession()->getCurrency()->getKey()
        );
    }

    public static function scopeCustomerGroups(BuilderContract $query, string $column = 'customer_group_id', ?string $table = null): void
    {
        $customerGroups = static::getStorefrontSession()->getCustomerGroups();
        $table = $table ?? (new Price)->getModel()->getTable();

        /** @var PriceBuilder $query */
        $query->when(
            value: fn () => $customerGroups
                ->filter(fn (?CustomerGroupContract $group = null) => $group)
                ->isNotEmpty(),
            callback: fn (BuilderContract $query) => $query
                ->where(fn (BuilderContract $query) => $query
                    ->whereIn(
                        "{$table}.customer_group_id",
                        $customerGroups->pluck('id')->toArray()
                    )
                    ->orWhere(
                        "{$table}.customer_group_id",
                        null
                    )
                ),
            default: fn (BuilderContract $query) => static::scopeBasePrices($query, $table),
        );
    }

    public static function scopeBasePrices(BuilderContract $query, ?string $table = null): void
    {
        $table = $table ?? (new Price)->getModel()->getTable();

        $query
            ->where("{$table}.min_quantity", 1)
            ->where("{$table}.customer_group_id", null);
    }

    public function inCurrency(): self
    {
        static::scopeCurrency($this);

        return $this;
    }

    public function inCustomerGroups(): self
    {
        static::scopeCustomerGroups($this);

        return $this;
    }

    public function base(): self
    {
        static::scopeBasePrices($this);

        return $this;
    }
}
