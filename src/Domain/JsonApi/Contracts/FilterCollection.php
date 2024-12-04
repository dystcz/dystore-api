<?php

namespace Dystore\Api\Domain\JsonApi\Contracts;

interface FilterCollection
{
    /**
     * Get filters to be registered.
     */
    public function toArray(): array;
}
