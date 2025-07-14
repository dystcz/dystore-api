<?php

namespace Dystore\Api\Domain\ProductAssociations\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Eloquent\Schema;
use Dystore\Api\Support\Models\Actions\SchemaType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation as EloquentRelation;
use Illuminate\Http\Request;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Resources\Relation;
use Lunar\Models\Contracts\Product;
use Lunar\Models\Contracts\ProductAssociation;

class ProductAssociationSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public static string $model = ProductAssociation::class;

    /**
     * Build an index query for this resource.
     */
    public function indexQuery(?Request $request, Builder $query): Builder
    {
        /** @var \Dystore\Api\Domain\ProductAssociations\Builders\ProductAssociationBuilder $query */
        return $query->published();
    }

    /**
     * Build a "relatable" query for this resource.
     */
    public function relatableQuery(?Request $request, EloquentRelation $query): EloquentRelation
    {
        /** @var \Dystore\Api\Domain\ProductAssociations\Builders\ProductAssociationBuilder $query */
        return $query->published();
    }

    /**
     * {@inheritDoc}
     */
    public function includePaths(): iterable
    {
        return [
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

            Str::make('type'),

            HasOne::make('target')
                ->type(SchemaType::get(Product::class))
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasOne::make('parent')
                ->type(SchemaType::get(Product::class))
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            ...parent::fields(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),

            Where::make('type'),

            ...parent::filters(),
        ];
    }
}
