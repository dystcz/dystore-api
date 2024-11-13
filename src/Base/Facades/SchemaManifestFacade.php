<?php

namespace Dystore\Api\Base\Facades;

use Dystore\Api\Base\Contracts\SchemaManifest as SchemaManifestContract;
use Dystore\Api\Base\Extensions\Extension;
use Dystore\Api\Domain\JsonApi\Contracts\Schema as SchemaContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void register(Collection $schemas) Register collection of schemas
 * @method static void registerSchema(string $schemaClass) Register a schema
 * @method static Collection getRegisteredSchemas() Get registered schemas
 * @method static array getServerSchemas() Get server schemas
 * @method static Collection getSchemaTypes() Get registered schema types
 * @method static SchemaContract getRegisteredSchema(string $schemaType) Get registered schema by type
 * @method static void removeSchema(string $schemaType) Remove schema from manifest
 * @method static Extension extend(string $class) Extend a schema
 *
 * @see \Dystore\Api\Base\Manifests\SchemaManifest
 */
class SchemaManifestFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return SchemaManifestContract::class;
    }
}
