<?php

namespace Dystore\Api\Domain\CustomerGroups\Concerns;

use Dystore\Api\Domain\CustomerGroups\Factories\CustomerGroupFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithDystoreApi
{
    use HashesRouteKey;

    public function initializeInteractsWithDystoreApi(): void
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        $this->mergeCasts([
            'default' => 'boolean',
        ]);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): CustomerGroupFactory
    {
        return CustomerGroupFactory::new();
    }
}
