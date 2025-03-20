<?php

namespace Dystore\Api\Hashids\Facades;

use Dystore\Api\Hashids\Contracts\HashidsConnectionsManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void registerConnections()
 * @method static Collection getConnections()
 * @method static string|null getModelConnection(string $model)
 *
 * @see \Dystore\Api\Hashids\Managers\HashidsConnectionsManager
 */
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
