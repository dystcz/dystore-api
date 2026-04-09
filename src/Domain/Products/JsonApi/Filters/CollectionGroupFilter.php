<?php

namespace Dystore\Api\Domain\Products\JsonApi\Filters;

use Illuminate\Database\Eloquent\Builder;
use LaravelJsonApi\Eloquent\Contracts\Filter;
use LaravelJsonApi\Eloquent\Filters\Concerns\DeserializesValue;

/**
 * Filter products by collections within specific collection groups.
 *
 * Accepts a nested array keyed by collection group handle, each containing
 * an `id` key with comma-separated collection IDs. Produces AND logic
 * between groups, OR logic within a group's collection IDs.
 *
 * Example: ?filter[collection_groups][group-1][id]=1,2,3&filter[collection_groups][group-2][id]=4,5,6
 *
 * @phpstan-consistent-constructor
 */
class CollectionGroupFilter implements Filter
{
    use DeserializesValue;

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function make(string $name): self
    {
        return new static($name);
    }

    public function key(): string
    {
        return $this->name;
    }

    public function isSingular(): bool
    {
        return false;
    }

    /**
     * Apply the filter to the query.
     *
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply($query, $value)
    {
        if (! is_array($value)) {
            return $query;
        }

        foreach ($value as $groupHandle => $filters) {
            if (! is_array($filters) || empty($filters['id'])) {
                continue;
            }

            $ids = is_string($filters['id'])
                ? array_filter(explode(',', $filters['id']), fn ($id) => $id !== '')
                : (array) $filters['id'];

            if (empty($ids)) {
                continue;
            }

            $query->whereHas('collections', function ($q) use ($groupHandle, $ids) {
                $q->whereHas('group', function ($q) use ($groupHandle) {
                    $q->where(
                        $q->getModel()->qualifyColumn('handle'),
                        $groupHandle,
                    );
                });

                $q->whereIn(
                    $q->getModel()->qualifyColumn('id'),
                    $ids,
                );
            });
        }

        return $query;
    }
}
