<?php

namespace Dystore\Api\Domain\Prices\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Lunar\Base\StorefrontSessionInterface;
use Lunar\Models\Contracts\CustomerGroup as CustomerGroupContract;

/**
 * @extends Builder<Model>
 */
class PriceBuilder extends Builder
{
    public function baseOrAll(): self
    {
        return $this->when(
            value: fn () => App::make(StorefrontSessionInterface::class)
                ->getCustomerGroups()
                ->filter(fn (CustomerGroupContract $group) => ! $group->default)
                ->isEmpty(),
            callback: fn (self $query) => $query->base(),
            default: fn (self $query) => $query,
        );
    }

    public function base(): self
    {
        $table = $this->getModel()->getTable();

        return $this
            ->where("{$table}.min_quantity", 1)
            ->where("{$table}.customer_group_id", null);
    }
}
