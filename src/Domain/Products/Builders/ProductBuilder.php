<?php

namespace Dystore\Api\Domain\Products\Builders;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Lunar\Models\Contracts\CustomerGroup as CustomerGroupContract;

/**
 * @method static ProductBuilder customerGroup(CustomerGroupContract|iterable|null $customerGroup = null, ?DateTime $startsAt = null, ?DateTime $endsAt = null)
 *
 * @extends Builder<Model>
 */
class ProductBuilder extends Builder
{
    /**
     * Scope a query to only include visible models.
     */
    public function visible(): self
    {
        return $this->published();
    }

    /**
     * Scope a query to only include published models.
     */
    public function published(): self
    {
        return $this->where('status', '!=', 'draft');
    }
}
