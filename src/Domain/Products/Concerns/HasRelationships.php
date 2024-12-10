<?php

namespace Dystore\Api\Domain\Products\Concerns;

use Dystore\Api\Domain\Prices\Models\Price;
use Dystore\Api\Domain\Products\Models\Product;
use Dystore\Api\Domain\ProductTypes\Models\ProductType;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Lunar\Base\StorefrontSessionInterface;
use Lunar\Models\Attribute;
use Lunar\Models\Contracts\CustomerGroup as CustomerGroupContract;
use Lunar\Models\ProductOptionValue;
use Lunar\Models\ProductVariant;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Staudenmeir\EloquentHasManyDeep\HasRelationships as DeepRelationships;

trait HasRelationships
{
    use DeepRelationships;

    /**
     * Get the mapped attributes relation.
     */
    public function attributes(): MorphToMany
    {
        /** @var Product $this */
        $prefix = Config::get('lunar.database.table_prefix');

        if ($this->relationLoaded('productType')) {
            return $this->productType->mappedAttributes();
        }

        $relation = new MorphToMany(
            Attribute::modelClass()::query(),
            new ProductType(['id' => $this->product_type_id]),
            'attributable',
            "{$prefix}attributables",
            'attributable_id',
            'attribute_id',
            'id',
            'id',
            'attributes',
            false,
        );

        return $relation->withTimestamps();
    }

    /**
     * Get prices through variants.
     */
    public function prices(): HasManyThrough
    {
        /** @var Product $this */
        return $this
            ->hasManyThrough(
                Price::modelClass(),
                ProductVariant::modelClass(),
                'product_id',
                'priceable_id'
            )
            ->baseOrAll()
            ->where(
                'priceable_type',
                (new (ProductVariant::modelClass()))->getMorphClass()
            );
    }

    /**
     * Get base prices through variants.
     */
    public function basePrices(): HasManyThrough
    {
        /** @var Product $this */
        return $this
            ->prices()
            ->base();
    }

    /**
     * Lowest price relation.
     */
    public function lowestPrice(): HasOneThrough
    {
        /** @var Product $this */
        $pricesTable = $this->prices()->getModel()->getTable();
        $variantsTable = $this->variants()->getModel()->getTable();

        return $this
            ->hasOneThrough(
                Price::modelClass(),
                ProductVariant::modelClass(),
                'product_id',
                'priceable_id'
            )
            ->baseOrAll()
            ->where($pricesTable.'.id', function ($query) use ($variantsTable, $pricesTable) {
                $query->select($pricesTable.'.id')
                    ->from($pricesTable)
                    ->where('priceable_type', (new (ProductVariant::modelClass()))->getMorphClass())
                    ->whereIn('priceable_id', function ($query) use ($variantsTable) {
                        $query->select('variants.id')
                            ->from("{$variantsTable} as variants")
                            ->where('variants.deleted_at', null)
                            ->whereRaw("variants.product_id = {$variantsTable}.product_id");
                    })
                    ->orderBy($pricesTable.'.price', 'asc')
                    ->limit(1);
            });
    }

    /**
     * Highest price relation.
     */
    public function highestPrice(): HasOneThrough
    {
        /** @var Product $this */
        $pricesTable = $this->prices()->getModel()->getTable();
        $variantsTable = $this->variants()->getModel()->getTable();

        return $this
            ->hasOneThrough(
                Price::modelClass(),
                ProductVariant::modelClass(),
                'product_id',
                'priceable_id'
            )
            ->baseOrAll()
            ->where($pricesTable.'.id', function ($query) use ($variantsTable, $pricesTable) {
                $query->select($pricesTable.'.id')
                    ->from($pricesTable)
                    ->where('priceable_type', (new (ProductVariant::modelClass()))->getMorphClass())
                    ->whereIn('priceable_id', function ($query) use ($variantsTable) {
                        $query->select('variants.id')
                            ->from("{$variantsTable} as variants")
                            ->where('variants.deleted_at', null)
                            ->whereRaw("variants.product_id = {$variantsTable}.product_id");
                    })
                    ->orderBy($pricesTable.'.price', 'desc')
                    ->limit(1);
            });
    }

    /**
     * Cheapest variant relation.
     */
    public function cheapestVariant(): HasOne
    {
        /** @var Product $this */
        $pricesTable = $this->prices()->getModel()->getTable();
        $variantsTable = $this->variants()->getModel()->getTable();

        return $this
            ->hasOne(ProductVariant::modelClass())
            ->where("{$variantsTable}.id", function (QueryBuilder $query) use ($variantsTable, $pricesTable) {
                $query
                    ->select('variants.id')
                    ->from("{$variantsTable} as variants")
                    ->join($pricesTable, function (JoinClause $join) {
                        $join->on('priceable_id', '=', 'variants.id')
                            ->where('priceable_type', (new (ProductVariant::modelClass()))->getMorphClass());
                    })
                    ->whereRaw("variants.product_id = {$variantsTable}.product_id")
                    ->when(
                        value: fn () => App::make(StorefrontSessionInterface::class)
                            ->getCustomerGroups()
                            ->filter(fn (CustomerGroupContract $group) => ! $group->default)
                            ->isEmpty(),
                        callback: fn (QueryBuilder $query) => $query->where("{$pricesTable}.min_quantity", 1)->where("{$pricesTable}.customer_group_id", null),
                        default: fn (QueryBuilder $query) => $query,
                    )
                    ->where('variants.deleted_at', null)
                    ->orderBy("{$pricesTable}.price", 'asc')
                    ->limit(1);
            });
    }

    /**
     * Most expensive variant relation.
     */
    public function mostExpensiveVariant(): HasOne
    {
        /** @var Product $this */
        $pricesTable = $this->prices()->getModel()->getTable();
        $variantsTable = $this->variants()->getModel()->getTable();

        return $this
            ->hasOne(ProductVariant::modelClass())
            ->where("{$variantsTable}.id", function (QueryBuilder $query) use ($variantsTable, $pricesTable) {
                $query
                    ->select('variants.id')
                    ->from("{$variantsTable} as variants")
                    ->join($pricesTable, function (JoinClause $join) {
                        $join->on('priceable_id', '=', 'variants.id')
                            ->where('priceable_type', (new (ProductVariant::modelClass()))->getMorphClass());
                    })
                    ->whereRaw("variants.product_id = {$variantsTable}.product_id")
                    ->when(
                        value: fn () => App::make(StorefrontSessionInterface::class)
                            ->getCustomerGroups()
                            ->filter(fn (CustomerGroupContract $group) => ! $group->default)
                            ->isEmpty(),
                        callback: fn (QueryBuilder $query) => $query->where("{$pricesTable}.min_quantity", 1)->where("{$pricesTable}.customer_group_id", null),
                        default: fn (QueryBuilder $query) => $query,
                    )
                    ->where('variants.deleted_at', null)
                    ->orderBy("{$pricesTable}.price", 'desc')
                    ->limit(1);
            });
    }

    /**
     * @return HasManyDeep<ProductOptionValue,Product>
     */
    public function variantValues(): HasManyDeep
    {
        /** @var Product $this */
        $variantsTable = $this->variants()->getModel()->getTable();
        $prefix = Config::get('lunar.database.table_prefix');

        return $this->hasManyDeepFromRelations(
            $this->variants(),
            (new ProductVariant)->values(),
        );
    }
}
