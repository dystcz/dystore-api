<?php

namespace Dystore\Api;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class JsonApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        \LaravelJsonApi\Laravel\LaravelJsonApi::defaultResource(
            \Dystore\Api\Domain\JsonApi\Resources\JsonApiResource::class,
        );
        \LaravelJsonApi\Laravel\LaravelJsonApi::defaultAuthorizer(
            \Dystore\Api\Domain\JsonApi\Authorizers\Authorizer::class,
        );
        \LaravelJsonApi\Laravel\LaravelJsonApi::defaultQuery(
            \Dystore\Api\Domain\JsonApi\Queries\Query::class,
        );
        \LaravelJsonApi\Laravel\LaravelJsonApi::defaultCollectionQuery(
            \Dystore\Api\Domain\JsonApi\Queries\CollectionQuery::class,
        );
        \LaravelJsonApi\Laravel\LaravelJsonApi::withCountQueryParameter(
            'with_count',
        );
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Register custom repository
        $this->app->bind(
            \LaravelJsonApi\Eloquent\Repository::class,
            fn () => \Dystore\Api\Domain\JsonApi\Eloquent\Repository::class,
        );

        // Register schema extension implementation
        $this->app->bind(
            \Dystore\Api\Base\Contracts\SchemaExtension::class,
            fn (Application $app, mixed $params) => new \Dystore\Api\Base\Extensions\SchemaExtension(...$params),
        );

        // Register schema manifest implementation
        $this->app->singleton(
            \Dystore\Api\Base\Contracts\SchemaManifest::class,
            fn (Application $app) => new \Dystore\Api\Base\Manifests\SchemaManifest,
        );

        // Register resource extension implementation
        $this->app->bind(
            \Dystore\Api\Base\Contracts\ResourceExtension::class,
            fn (Application $app, mixed $params) => new \Dystore\Api\Base\Extensions\ResourceExtension(...$params),
        );

        // Register resource manifest implementation
        $this->app->singleton(
            \Dystore\Api\Base\Contracts\ResourceManifest::class,
            fn (Application $app) => new \Dystore\Api\Base\Manifests\ResourceManifest,
        );
    }
}
