<?php

namespace Dystore\Api\Base\Facades;

use Dystore\Api\Base\Contracts\ResourceManifest as ResourceManifestContract;
use Dystore\Api\Base\Extensions\Extension;
use Dystore\Api\Domain\JsonApi\Contracts\Schema as SchemaContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void register(Collection $schemas)
 * @method static void registerSchema(string $schemaClass)
 * @method static Collection getRegisteredSchemas()
 * @method static Collection getSchemaTypes()
 * @method static SchemaContract getRegisteredSchema(string $schemaType)
 * @method static void removeSchema(string $schemaType)
 * @method static Extension extend(string $class)
 *
 * @see \Dystore\Api\Base\Manifests\SchemaManifest
 */
class ResourceManifestFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return ResourceManifestContract::class;
    }
}
