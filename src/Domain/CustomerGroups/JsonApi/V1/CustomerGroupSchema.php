<?php

namespace Dystore\Api\Domain\CustomerGroups\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Eloquent\Schema;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\Str;
use Lunar\Models\Contracts\CustomerGroup;

class CustomerGroupSchema extends Schema
{
    /**
     * {@inheritDoc}
     */
    public static string $model = CustomerGroup::class;

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

            Str::make('name'),
            Str::make('handle'),
            Boolean::make('default'),

            ...parent::fields(),
        ];
    }
}
