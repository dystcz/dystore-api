<?php

namespace Dystore\Api\Domain\Users\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Eloquent\Schema;
use Dystore\Api\Domain\Users\Contracts\User;
use Dystore\Api\Support\Models\Actions\SchemaType;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasOne;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Resources\Relation;
use Lunar\Models\Contracts\Customer;
use Lunar\Models\Contracts\Order;

class UserSchema extends Schema
{
    /**
     * The model the schema corresponds to.
     */
    public static string $model = User::class;

    /**
     * The relationships that should always be eager loaded.
     */
    public function with(): array
    {
        return [
            ...parent::with(),
        ];
    }

    /**
     * Get the include paths supported by this resource.
     *
     * @return string[]|iterable
     */
    public function includePaths(): iterable
    {
        return [
            ...parent::includePaths(),
        ];
    }

    /**
     * Get the resource fields.
     */
    public function fields(): array
    {
        return [
            $this->idField(),

            Str::make('name'),
            Str::make('first_name'),
            Str::make('last_name'),
            Str::make('full_name'),
            Str::make('email'),
            Str::make('phone'),

            Str::make('password')->hidden(),
            Str::make('password_confirmation')->hidden(),
            Str::make('old_password')->hidden(),
            Str::make('token')->hidden(),

            Boolean::make('accept_terms')->hidden(),

            HasOne::make('avatar', 'avatar')
                ->readOnly()
                ->type('media')
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasMany::make('orders')
                ->type(SchemaType::get(Order::class))
                ->readOnly()
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            BelongsToMany::make('customers')
                ->type(SchemaType::get(Customer::class))
                ->readOnly()
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            ...parent::fields(),
        ];
    }
}
