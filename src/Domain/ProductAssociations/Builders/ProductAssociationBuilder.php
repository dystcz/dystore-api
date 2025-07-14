<?php

namespace Dystore\Api\Domain\ProductAssociations\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends Builder<Model>
 */
class ProductAssociationBuilder extends Builder
{
    /**
     * Scope a query to only include published models.
     */
    public function published(): self
    {
        return $this
            ->whereHas('target', fn ($query) => $query->published())
            ->whereHas('parent', fn ($query) => $query->published());
    }
}
