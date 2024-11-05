<?php

namespace Dystcz\LunarApi\Domain\ProductOptionValues\JsonApi\V1;

use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Schema;
use Dystcz\LunarApi\Support\Models\Actions\SchemaType;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Resources\Relation;
use Lunar\Models\Contracts\ProductOption;
use Lunar\Models\Contracts\ProductOptionValue;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductOptionValueSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public static string $model = ProductOptionValue::class;

    /**
     * {@inheritDoc}
     */
    public function includePaths(): iterable
    {
        return [
            'images',
            'product_option',

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

            Str::make('name')
                ->readOnly()
                ->extractUsing(
                    fn (ProductOptionValue $model, string $attribute) => $model->translate($attribute),
                ),

            Str::make('product_option_handle', 'handle')
                ->readOnly()
                ->on('option'),

            BelongsTo::make('product_option', 'option')
                ->readOnly()
                ->type(SchemaType::get(ProductOption::class))
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasMany::make('images', 'images')
                ->type(SchemaType::get(Media::class))
                ->canCount()
                ->countAs('images_count')
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
            ...parent::filters(),
        ];
    }
}
