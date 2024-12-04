<?php

namespace Dystore\Api;

use Dystore\Api\Facades\Api;
use Dystore\Api\Hashids\Facades\HashidsConnections;
use Illuminate\Support\ServiceProvider;

class ApiHashidsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if (Api::usesHashids()) {
            HashidsConnections::registerConnections();
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration.
        $this->mergeConfigFrom(__DIR__.'/../config/hashids.php', 'hashids');

        // Register payment adapters register.
        $this->app->singleton(
            \Dystore\Api\Hashids\Contracts\HashidsConnectionsManager::class,
            fn () => new \Dystore\Api\Hashids\Managers\HashidsConnectionsManager,
        );
    }
}
