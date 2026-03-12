<?php

namespace Dystore\Api\Domain\Prices\Scopes;

use Dystore\Api\Domain\Prices\Builders\PriceBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ApiPricingScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        /** @var PriceBuilder $builder */
        $builder
            ->inCurrency()
            ->inCustomerGroups();
    }
}
