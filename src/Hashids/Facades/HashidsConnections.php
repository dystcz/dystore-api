<?php

namespace Dystore\Api\Hashids\Facades;

use Dystore\Api\Hashids\Contracts\HashidsConnectionsManager;
use Illuminate\Support\Facades\Facade;

class HashidsConnections extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return HashidsConnectionsManager::class;
    }
}
