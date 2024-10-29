<?php

namespace Dystcz\LunarApi\Domain\ProductOptionValues\Concerns;

use Dystcz\LunarApi\Domain\ProductOptionValues\Factories\ProductOptionValueFactory;
use Dystcz\LunarApi\Domain\ProductOptionValues\Models\ProductOptionValue;
use Dystcz\LunarApi\Hashids\Traits\HashesRouteKey;
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
