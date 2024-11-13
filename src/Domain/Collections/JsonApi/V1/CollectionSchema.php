<?php

namespace Dystore\Api\Domain\Collections\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Eloquent\Fields\AttributeData;
use Dystore\Api\Domain\JsonApi\Eloquent\Schema;
use Dystore\Api\Domain\JsonApi\Eloquent\Sorts\InDefaultOrder;
use Dystore\Api\Support\Models\Actions\SchemaType;
use LaravelJsonApi\Eloquent\Fields\Number;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Filters\Has;
use LaravelJsonApi\Eloquent\Filters\WhereHas;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Filters\WhereNull;
use LaravelJsonApi\Eloquent\Resources\Relation;
use Lunar\Models\Contracts\Collection;
use Lunar\Models\Contracts\CollectionGroup;
use Lunar\Models\Contracts\Url;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CollectionSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public static string $model = Collection::class;

    /**
     * {@inheritDoc}
     */
    protected $defaultSort = 'ordered';

    /**
     * {@inheritDoc}
     */
    public function with(): array
    {
        return [
            'attributes',

            ...parent::with(),
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
            'thumbnail',
            'urls',

            'group',

            'products',
            'products.default_url',
            'products.images',
            'products.lowest_price',
            'products.prices',
            'products.thumbnail',
            'products.urls',

            ...parent::includePaths(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [
            $this->idField(),

            AttributeData::make('attribute_data')
                ->groupAttributes(),

            Number::make('parent_id', 'parent_id')
                ->hidden(),

            HasOne::make('default_url', 'defaultUrl')
                ->type(SchemaType::get(Url::class))
                ->retainFieldName()
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasMany::make('images', 'images')
                ->type(SchemaType::get(Media::class))
                ->canCount()
                ->countAs('images_count')
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            BelongsTo::make('group', 'group')
                ->type(SchemaType::get(CollectionGroup::class))
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasMany::make('products')
                ->canCount()
                ->countAs('products_count')
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasOne::make('thumbnail', 'thumbnail')
                ->type(SchemaType::get(Media::class))
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasMany::make('urls')
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

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

            InDefaultOrder::make('ordered'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),

            WhereHas::make($this, 'urls', 'url')
                ->singular(),

            WhereHas::make($this, 'urls', 'urls'),

            WhereHas::make($this, 'group', 'group'),

            WhereNull::make('root', 'parent_id'),

            Has::make($this, 'products', 'has_products'),

            ...parent::filters(),
        ];
    }
}
