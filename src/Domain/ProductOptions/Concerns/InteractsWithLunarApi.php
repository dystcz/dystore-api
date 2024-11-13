<?php

namespace Dystore\Api\Domain\ProductOptions\Concerns;

use Dystore\Api\Domain\ProductOptions\Factories\ProductOptionFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): ProductOptionFactory
    {
        return ProductOptionFactory::new();
    }

    /**
     * Get label attribute.
     */
    protected function label(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value = null) => $value ? json_decode($value) : [],
            set: fn ($value) => json_encode($value),
        );
    }
}
