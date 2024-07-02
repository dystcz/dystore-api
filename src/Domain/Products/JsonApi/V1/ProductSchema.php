<?php

namespace Dystcz\LunarApi\Domain\Products\JsonApi\V1;

use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Fields\AttributeData;
use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Schema;
use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Sorts\InRandomOrder;
use Dystcz\LunarApi\Domain\Products\JsonApi\Filters\InStockFilter;
use Dystcz\LunarApi\Domain\Products\JsonApi\Filters\ProductFilterCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use LaravelJsonApi\Eloquent\Fields\ArrayHash;
use LaravelJsonApi\Eloquent\Fields\Map;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasManyThrough;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOneThrough;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereHas;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Filters\WhereIdNotIn;
use LaravelJsonApi\Eloquent\Resources\Relation;
use Lunar\Models\Product;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ProductSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public static string $model = Product::class;

    /**
     * Build an index query for this resource.
     */
    public function indexQuery(?Request $request, Builder $query): Builder
    {
        return $query->where('status', '!=', 'draft');
    }

    /**
     * {@inheritDoc}
     */
    public function with(): array
    {
        return [
            'productType',
            'productType.mappedAttributes',
            'productType.mappedAttributes.attributeGroup',
            ...parent::with(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function mergeIncludePathsFrom(): iterable
    {
        return [
            'associations' => ['associations', 'inverse_associations'],
            'variants' => ['cheapest_variant', 'variants'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function includePaths(): iterable
    {
        return [
            'default_url',
            'images',
            'lowest_price',
            'prices',
            'thumbnail',
            'urls',

            'brand',
            'brand.default_url',
            'brand.thumbnail',

            'cheapest_variant',
            'cheapest_variant.images',
            'cheapest_variant.prices',

            'collections',
            'collections.default_url',
            'collections.group',

            'product_type',
            'tags',

            ...parent::includePaths(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function fields(): iterable
    {
        return [
            $this->idField(),

            Str::make('status')
                ->readOnly(),

            AttributeData::make('attribute_data')
                ->readOnly()
                ->groupAttributes(),

            Map::make('availability', [
                ArrayHash::make('status')->extractUsing(static fn (Product $model) => $model->availability->toArray()),
            ])->readOnly(),

            HasMany::make('attributes', 'attributes')
                ->type('attributes')
                ->serializeUsing(
                    static fn ($relation) => $relation->withoutLinks(),
                ),

            HasMany::make('associations')
                ->type('associations')
                ->canCount(),

            BelongsTo::make('brand'),

            HasMany::make('channels')
                ->canCount()
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasOne::make('cheapest_variant', 'cheapestVariant')
                ->type('variants')
                ->retainFieldName(),

            HasOne::make('most_expensive_variant', 'mostExpensiveVariant')
                ->type('variants')
                ->retainFieldName(),

            HasMany::make('collections')
                ->canCount(),

            HasOne::make('default_url', 'defaultUrl')
                ->type('urls')
                ->retainFieldName(),

            HasMany::make('images', 'images')
                ->type('media')
                ->canCount(),

            HasMany::make('inverse_associations', 'inverseAssociations')
                ->type('associations')
                ->retainFieldName()
                ->canCount(),

            HasOneThrough::make('lowest_price', 'lowestPrice')
                ->type('prices')
                ->retainFieldName(),

            HasOneThrough::make('highest_price', 'highestPrice')
                ->type('prices')
                ->retainFieldName(),

            HasManyThrough::make('prices')
                ->canCount(),

            BelongsTo::make('product_type', 'productType')
                ->retainFieldName()
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasMany::make('tags')
                ->canCount(),

            HasOne::make('thumbnail', 'thumbnail')
                ->type('media'),

            HasMany::make('urls')
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasMany::make('variants')
                ->canCount(),

            ...parent::fields(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function sortables(): iterable
    {
        return [
            ...parent::sortables(),

            InRandomOrder::make('random'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),

            WhereIdNotIn::make($this),

            InStockFilter::make('in_stock'),

            WhereHas::make($this, 'prices'),

            WhereHas::make($this, 'brand'),

            WhereHas::make($this, 'urls', 'url')
                ->singular(),

            WhereHas::make($this, 'urls', 'urls'),

            WhereHas::make($this, 'product_type'),

            WhereHas::make($this, 'channels'),

            WhereHas::make($this, 'status'),

            WhereHas::make($this, 'collections'),

            ...(new ProductFilterCollection)->toArray(),

            ...parent::filters(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function type(): string
    {
        return 'products';
    }
}
