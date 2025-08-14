<?php

namespace Dystore\Api\Base\Concerns;

use Carbon\Carbon;
use Dystore\Api\Base\Enums\PublishedStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait PublishableScope
{
    /**
     * Scope published.
     */
    public function published(): self
    {
        /** @var Builder */
        $builder = $this;

        return $builder
            ->when(
                Schema::hasColumn($builder->getModel()->getTable(), 'status'),
                fn (Builder $query) => $query->where('status', PublishedStatus::PUBLISHED)
            )
            ->where(
                'published_at',
                '!=',
                null,
            )
            ->where(
                'published_at',
                '<=',
                Carbon::now(),
            );
    }
}
