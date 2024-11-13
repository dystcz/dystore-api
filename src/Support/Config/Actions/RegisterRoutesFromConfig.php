<?php

namespace Dystore\Api\Support\Config\Actions;

use Dystore\Api\Support\Actions\Action;
use Dystore\Api\Support\Config\Collections\DomainConfigCollection;

class RegisterRoutesFromConfig extends Action
{
    public function handle(?string $configKey = null): void
    {
        DomainConfigCollection::fromConfig($configKey ?? 'lunar-api.domains')
            ->getRoutes()
            ->each(fn (string $routeGroup, string $schemaType) => $routeGroup::make($schemaType)->routes());
    }
}
