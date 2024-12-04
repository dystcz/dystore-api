<?php

namespace Dystore\Api\Base\Manifests;

use Dystore\Api\Base\Contracts\Extendable;

abstract class Manifest
{
    /**
     * @var array<class-string<Extendable>, Extension>
     */
    public array $extensions = [];
}
