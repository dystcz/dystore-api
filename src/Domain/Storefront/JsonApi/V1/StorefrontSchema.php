<?php

namespace Dystore\Api\Domain\Storefront\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Core\Schema\TypeResolver;
use Dystore\Api\Domain\Storefront\Entities\Storefront;
use Dystore\Api\Support\Models\Actions\SchemaType;
use LaravelJsonApi\Core\Schema\Schema;
use LaravelJsonApi\NonEloquent\Fields\ID;
use LaravelJsonApi\NonEloquent\Fields\ToMany;
use LaravelJsonApi\NonEloquent\Fields\ToOne;
use Lunar\Models\Contracts\Channel;
use Lunar\Models\Contracts\Currency;
use Lunar\Models\Contracts\Customer;
use Lunar\Models\Contracts\CustomerGroup;

class StorefrontSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public static string $model = Storefront::class;

    /**
     * {@inheritDoc}
     */
    public function fields(): iterable
    {
        return [
            ID::make()
                ->matchAs('[a-zA-Z0-9_]+'),

            ToOne::make('channel')
                ->type(SchemaType::get(Channel::class)),

            ToOne::make('customer')
                ->type(SchemaType::get(Customer::class)),

            ToOne::make('currency')
                ->type(SchemaType::get(Currency::class)),

            ToMany::make('customer_groups', 'customerGroups')
                ->retainFieldName()
                ->type(SchemaType::get(CustomerGroup::class)),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function authorizable(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function repository(): StorefrontRepository
    {
        return StorefrontRepository::make()
            ->withServer($this->server)
            ->withSchema($this);
    }

    /**
     * {@inheritDoc}
     */
    public static function type(): string
    {
        $resolver = new TypeResolver;

        return $resolver(static::class);
    }

    /**
     * {@inheritDoc}
     */
    public function uriType(): string
    {
        if ($this->uriType) {
            return $this->uriType;
        }

        return $this->uriType = $this->type();
    }
}
