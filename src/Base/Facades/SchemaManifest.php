<?php

namespace Dystore\Api\Base\Facades;

use Dystore\Api\Base\Contracts\SchemaManifest as SchemaManifestContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Dystore\Api\Base\Contracts\SchemaExtension extend(string $class)
 * @method static void register(\Illuminate\Support\Collection $schemas)
 * @method static void registerSchema(string $schemaClass)
 * @method static \Illuminate\Support\Collection getRegisteredSchemas()
 * @method static array getServerSchemas()
 * @method static \Illuminate\Support\Collection getSchemaTypes()
 * @method static \Dystore\Api\Domain\JsonApi\Contracts\Schema getRegisteredSchema(string $schemaType)
 * @method static void removeSchema(string $schemaType)
 *
 * @see \Dystore\Api\Base\Manifests\SchemaManifest
 */
class SchemaManifest extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return SchemaManifestContract::class;
    }
}
