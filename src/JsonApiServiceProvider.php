<?php

namespace Dystore\Api;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use LaravelJsonApi\Eloquent\Repository;
use LaravelJsonApi\Laravel\LaravelJsonApi;

class JsonApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        LaravelJsonApi::defaultResource(
            Domain\JsonApi\Resources\JsonApiResource::class,
        );
        LaravelJsonApi::defaultAuthorizer(
            Domain\JsonApi\Authorizers\Authorizer::class,
        );
        LaravelJsonApi::defaultQuery(
            Domain\JsonApi\Queries\Query::class,
        );
        LaravelJsonApi::defaultCollectionQuery(
            Domain\JsonApi\Queries\CollectionQuery::class,
        );
        LaravelJsonApi::withCountQueryParameter(
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
            Repository::class,
            fn () => Domain\JsonApi\Eloquent\Repository::class,
        );

        // Register schema extension implementation
        $this->app->bind(
            Base\Contracts\SchemaExtension::class,
            fn (Application $app, mixed $params) => new Base\Extensions\SchemaExtension(...$params),
        );

        // Register schema manifest implementation
        $this->app->singleton(
            Base\Contracts\SchemaManifest::class,
            fn (Application $app) => new Base\Manifests\SchemaManifest,
        );

        // Register resource extension implementation
        $this->app->bind(
            Base\Contracts\ResourceExtension::class,
            fn (Application $app, mixed $params) => new Base\Extensions\ResourceExtension(...$params),
        );

        // Register resource manifest implementation
        $this->app->singleton(
            Base\Contracts\ResourceManifest::class,
            fn (Application $app) => new Base\Manifests\ResourceManifest,
        );
    }
}
