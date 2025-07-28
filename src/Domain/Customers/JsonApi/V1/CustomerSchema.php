<?php

namespace Dystore\Api\Domain\Customers\JsonApi\V1;

use Dystore\Api\Domain\Addresses\Models\Address;
use Dystore\Api\Domain\CustomerGroups\Models\CustomerGroup;
use Dystore\Api\Domain\JsonApi\Eloquent\Fields\AttributeData;
use Dystore\Api\Domain\JsonApi\Eloquent\Schema;
use Dystore\Api\Domain\Orders\Models\Order;
use Dystore\Api\Domain\Users\Models\User;
use Dystore\Api\Support\Models\Actions\SchemaType;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Resources\Relation;
use Lunar\Models\Contracts\Customer;

class CustomerSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public static string $model = Customer::class;

    /**
     * {@inheritDoc}
     */
    public function includePaths(): iterable
    {
        return [
            'orders',
            'orders.lines',
            'orders.lines.purchasable',
            'addresses',
            'addresses.country',

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

            Str::make('title'),
            Str::make('first_name'),
            Str::make('last_name'),
            Str::make('company_name'),
            Str::make('account_ref'),
            Str::make('vat_no', 'tax_identifier'),

            HasMany::make('orders')
                ->type(SchemaType::get(Order::class))
                ->canCount()
                ->countAs('orders_count')
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            HasMany::make('addresses')
                ->type(SchemaType::get(Address::class))
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            BelongsToMany::make('users')
                ->type(SchemaType::get(User::class))
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            BelongsToMany::make('customer_groups', 'customerGroups')
                ->type(SchemaType::get(CustomerGroup::class))
                ->retainFieldName()
                ->canCount()
                ->countAs('customer_groups_count')
                ->serializeUsing(static fn (Relation $relation) => $relation->withoutLinks()),

            ...parent::fields(),
        ];
    }
}
