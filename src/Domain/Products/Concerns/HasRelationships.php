<?php

namespace Dystore\Api\Domain\Products\Concerns;

use Dystore\Api\Domain\Prices\Builders\PriceBuilder;
use Dystore\Api\Domain\Prices\Models\Price;
use Dystore\Api\Domain\Products\Models\Product;
use Dystore\Api\Domain\Products\Relations\BelongsToManyThrough;
use Dystore\Api\Domain\ProductTypes\Models\ProductType;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Config;
use Lunar\Models\Attribute;
use Lunar\Models\ProductOptionValue;
use Lunar\Models\ProductVariant;

trait HasRelationships
{
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
     * Get base prices through variants.
     */
    public function basePrices(): HasManyThrough
    {
        /** @var Product $this */
        /** @var PriceBuilder $builder */
        $builder = $this->prices();

        return $builder->base();
    }

    /**
     * Get lowest price through variants.
     */
    public function price(): HasOneThrough
    {
        return $this->lowestPrice();
    }

    /**
     * Get lowest price through variants.
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
            ->where("{$pricesTable}.id", function (QueryBuilder $query) use ($variantsTable, $pricesTable) {
                $query
                    ->select($pricesTable.'.id')
                    ->from($pricesTable)
                    ->where("{$pricesTable}.priceable_type", (new (ProductVariant::modelClass()))->getMorphClass())
                    ->whereIn("{$pricesTable}.priceable_id", function ($query) use ($variantsTable) {
                        $query->select('variants.id')
                            ->from("{$variantsTable} as variants")
                            ->where('variants.deleted_at', null)
                            ->whereRaw("variants.product_id = {$variantsTable}.product_id");
                    });

                PriceBuilder::scopeCurrency($query);
                PriceBuilder::scopeCustomerGroups($query);

                $query
                    ->orderBy($pricesTable.'.price', 'asc')
                    ->limit(1);
            });
    }

    /**
     * Get highest price through variants.
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
            ->where("{$pricesTable}.id", function (QueryBuilder $query) use ($variantsTable, $pricesTable) {
                $query->select($pricesTable.'.id')
                    ->from($pricesTable)
                    ->where("{$pricesTable}.priceable_type", (new (ProductVariant::modelClass()))->getMorphClass())
                    ->whereIn("{$pricesTable}.priceable_id", function ($query) use ($variantsTable) {
                        $query->select('variants.id')
                            ->from("{$variantsTable} as variants")
                            ->where('variants.deleted_at', null)
                            ->whereRaw("variants.product_id = {$variantsTable}.product_id");
                    });

                PriceBuilder::scopeCurrency($query);
                PriceBuilder::scopeCustomerGroups($query);

                $query
                    ->orderBy($pricesTable.'.price', 'desc')
                    ->limit(1);
            });
    }

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
                    ->join($pricesTable, function (JoinClause $join) use ($pricesTable) {
                        $join
                            ->on("{$pricesTable}.priceable_id", '=', 'variants.id')
                            ->where("{$pricesTable}.priceable_type", (new (ProductVariant::modelClass()))->getMorphClass());

                        PriceBuilder::scopeCurrency($join);
                        PriceBuilder::scopeCustomerGroups($join);
                    })
                    ->whereRaw("variants.product_id = {$variantsTable}.product_id")
                    ->where('variants.deleted_at', null)
                    ->orderBy("{$pricesTable}.price", 'asc')
                    ->limit(1);
            });
    }

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
                    ->join($pricesTable, function (JoinClause $join) use ($pricesTable) {
                        $join
                            ->on("{$pricesTable}.priceable_id", '=', 'variants.id')
                            ->where("{$pricesTable}.priceable_type", (new (ProductVariant::modelClass()))->getMorphClass());

                        PriceBuilder::scopeCurrency($join);
                        PriceBuilder::scopeCustomerGroups($join);
                    })
                    ->whereRaw("variants.product_id = {$variantsTable}.product_id")
                    ->where('variants.deleted_at', null)
                    ->orderBy("{$pricesTable}.price", 'desc')
                    ->limit(1);
            });
    }

    /**
     * Get distinct product option values from all variants.
     */
    public function variantValues(): BelongsToMany
    {
        /** @var Product $this */
        $prefix = Config::get('lunar.database.table_prefix');
        $pivotTable = "{$prefix}product_option_value_product_variant";
        $variantsTable = (new (ProductVariant::modelClass()))->getTable();

        $instance = $this->newRelatedInstance(ProductOptionValue::modelClass());

        return new BelongsToManyThrough(
            $instance->newQuery(),
            $this,
            $pivotTable,
            'variant_id',
            'value_id',
            'id',
            'id',
            $variantsTable,
            'product_id',
            'variantValues'
        );
    }
}
