<?php

namespace Dystore\Api\Domain\CustomerGroups\Concerns;

use Dystore\Api\Domain\CustomerGroups\Factories\CustomerGroupFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Eloquent\Model;

trait InteractsWithDystoreApi
{
    use HashesRouteKey;

    public function initializeInteractsWithDystoreApi(): void
    {
        /** @var Model $this */
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
