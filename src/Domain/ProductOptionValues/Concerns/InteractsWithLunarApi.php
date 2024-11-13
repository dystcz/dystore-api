<?php

namespace Dystore\Api\Domain\ProductOptionValues\Concerns;

use Dystore\Api\Domain\ProductOptionValues\Factories\ProductOptionValueFactory;
use Dystore\Api\Domain\ProductOptionValues\Models\ProductOptionValue;
use Dystore\Api\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Config;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): ProductOptionValueFactory
    {
        return ProductOptionValueFactory::new();
    }

    public function images(): MorphMany
    {
        /** @var ProductOptionValue $this */

        return $this
            ->media()
            ->where(
                'collection_name',
                Config::get('lunar.media.collection'),
            );
    }
}
