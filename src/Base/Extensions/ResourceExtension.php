<?php

namespace Dystore\Api\Base\Extensions;

use Dystore\Api\Base\Contracts\Extendable as ExtendableContract;
use Dystore\Api\Base\Contracts\ResourceExtension as ResourceExtensionContract;
use Dystore\Api\Base\Data\ExtensionValueCollection;

/**
 * @property class-string<ExtendableContract> $class
 *
 * @method ExtensionValueCollection attributes()
 * @method self setAttributes(iterable|callable $value)
 * @method ExtensionValueCollection relationships()
 * @method iterable setRelationships(iterable|callable $value)
 */
class ResourceExtension extends Extension implements ResourceExtensionContract
{
    public function __construct(
        protected string $class,

        /**
         * Attributes method extensions.
         */
        protected ExtensionValueCollection $attributes = new ExtensionValueCollection,

        /**
         * Relationships method extensions.
         */
        protected ExtensionValueCollection $relationships = new ExtensionValueCollection,
    ) {
        parent::__construct($class);
    }
}
