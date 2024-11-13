<?php

namespace Dystore\Api\Domain\Channels\Concerns;

use Dystore\Api\Domain\Channels\Factories\ChannelFactory;
use Dystore\Api\Hashids\Traits\HashesRouteKey;

trait InteractsWithLunarApi
{
    use HashesRouteKey;

    /**
     * Return a new factory instance for the model.
     */
    protected static function newFactory(): ChannelFactory
    {
        return ChannelFactory::new();
    }
}
