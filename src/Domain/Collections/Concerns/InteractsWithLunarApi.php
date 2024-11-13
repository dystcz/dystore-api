<?php

namespace Dystore\Api\Domain\Collections\Concerns;

use Dystore\Api\Domain\Attributes\Traits\InteractsWithAttributes;
use Dystore\Api\Domain\Collections\Factories\CollectionFactory;
use Dystore\Api\Domain\Collections\Models\Collection;
use Dystore\Api\Hashids\Traits\HashesRouteKey;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Config;

trait InteractsWithLunarApi
{
    use HashesRouteKey;
    use InteractsWithAttributes;

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): CollectionFactory
    {
        return CollectionFactory::new();
    }

    public function images(): MorphMany
    {
        /** @var Collection $this */
        return $this
            ->media()
            ->where(
                'collection_name',
                Config::get('lunar.media.collection'),
            );
    }
}
