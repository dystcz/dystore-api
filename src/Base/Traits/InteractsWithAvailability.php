<?php

namespace Dystore\Api\Base\Traits;

use Dystore\Api\Base\Contracts\HasAvailabilityStatus;
use Dystore\Api\Domain\Products\Enums\Availability;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait InteractsWithAvailability
{
    use CanBeAlwaysPurchasable;
    use CanBeBackordered;
    use CanBeInStock;
    use CanBePreordered;

    /**
     * Get availability.
     */
    public function getAvailability(): Availability
    {
        /** @var HasAvailabilityStatus $this */
        return Availability::of($this);
    }

    /**
     * Get availability attribute.
     */
    public function availability(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getAvailability()
        );
    }

    /**
     * Prepare model for availability evaluation.
     */
    public function prepareModelForAvailabilityEvaluation(): void
    {
        //
    }
}
