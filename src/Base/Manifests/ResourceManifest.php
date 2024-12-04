<?php

namespace Dystore\Api\Base\Manifests;

use Dystore\Api\Base\Contracts\ResourceExtension as ResourceExtensionContract;
use Dystore\Api\Base\Contracts\ResourceManifest as ResourceManifestContract;
use Dystore\Api\Domain\JsonApi\Resources\JsonApiResource;
use Illuminate\Support\Facades\App;

/**
 * @property array<ResourceExtensionContract> $extensions
 */
class ResourceManifest extends Manifest implements ResourceManifestContract
{
    /**
     * Get resource extension for a given resource class.
     *
     * @param  class-string<Schema>  $class
     *
     * @deprecated Use ResourceManifest::extend() instead.
     */
    public static function for(string $class): ResourceExtensionContract
    {
        return self::extend($class);
    }

    /**
     * Get resource extension for a given resource class.
     *
     * @param  class-string<JsonApiResource>  $class
     */
    public static function extend(string $class): ResourceExtensionContract
    {
        $self = App::make(ResourceManifestContract::class);

        $extension = $self->extensions[$class] ??= App::make(ResourceExtensionContract::class, ['class' => $class]);

        return $extension;
    }
}
