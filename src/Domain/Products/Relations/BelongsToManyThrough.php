<?php

namespace Dystore\Api\Domain\Products\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BelongsToManyThrough extends BelongsToMany
{
    /**
     * The intermediate table name.
     */
    protected string $throughTable;

    /**
     * The foreign key on the intermediate table.
     */
    protected string $throughForeignKey;

    /**
     * Flag to track if distinct has been applied.
     */
    protected bool $distinctApplied = false;

    /**
     * Create a new belongs to many through relationship instance.
     */
    public function __construct(
        Builder $query,
        Model $parent,
        string $table,
        string $foreignPivotKey,
        string $relatedPivotKey,
        string $parentKey,
        string $relatedKey,
        string $throughTable,
        string $throughForeignKey,
        ?string $relationName = null
    ) {
        $this->throughTable = $throughTable;
        $this->throughForeignKey = $throughForeignKey;

        parent::__construct(
            $query,
            $parent,
            $table,
            $foreignPivotKey,
            $relatedPivotKey,
            $parentKey,
            $relatedKey,
            $relationName
        );
    }

    /**
     * Get the pivot columns for the relation.
     * Return empty array to prevent pivot columns from being selected.
     */
    protected function aliasedPivotColumns(): array
    {
        // Don't select any pivot columns for a "through" relationship
        // This prevents duplicates caused by different pivot combinations
        return [];
    }

    /**
     * Set the select clause for the relation query.
     * Override to ensure we only select from the related table.
     */
    protected function shouldSelect(array $columns = ['*']): array
    {
        if ($columns == ['*']) {
            $columns = [$this->related->getTable().'.*'];
        }

        return array_merge($columns, $this->aliasedPivotColumns());
    }

    /**
     * Set the join clause for the relation query.
     */
    protected function performJoin($query = null): static
    {
        $query = $query ?: $this->query;

        // Explicitly select only related table columns to make GROUP BY work properly
        if (empty($query->getQuery()->columns)) {
            $query->select($this->related->getTable().'.*');
        }

        // Join to the pivot table
        $query->join($this->table, $this->getQualifiedRelatedKeyName(), '=', $this->getQualifiedRelatedPivotKeyName());

        // Join to the intermediate (through) table
        $query->join(
            $this->throughTable,
            $this->table.'.'.$this->foreignPivotKey,
            '=',
            $this->throughTable.'.id'
        );

        return $this;
    }

    /**
     * Set the where clause for the relation query.
     */
    protected function addWhereConstraints(): static
    {
        $this->query->where(
            $this->throughTable.'.'.$this->throughForeignKey,
            '=',
            $this->parent->{$this->parentKey}
        );

        return $this;
    }

    /**
     * Set the constraints for an eager load of the relation.
     */
    public function addConstraints(): void
    {
        parent::addConstraints();

        // Apply GROUP BY to ensure distinct results
        // This must be done in addConstraints so it's active before pagination
        $this->applyDistinctConstraints();

        // Ensure we only select related table columns for GROUP BY to work
        $this->query->getQuery()->columns = null;
        $this->query->select($this->related->getTable().'.*');
    }

    /**
     * Set the constraints for eager loading of the relation.
     */
    public function addEagerConstraints(array $models): void
    {
        // Don't call parent - we need custom constraints for the "through" relationship
        $whereIn = $this->whereInMethod($this->parent, $this->parentKey);

        $this->query->{$whereIn}(
            $this->throughTable.'.'.$this->throughForeignKey,
            $this->getKeys($models, $this->parentKey)
        );

        // Apply GROUP BY to ensure distinct results during eager loading
        $this->applyDistinctConstraints();

        // Ensure we only select related table columns for GROUP BY to work
        $this->query->getQuery()->columns = null;
        $this->query->select($this->related->getTable().'.*');
    }

    /**
     * Match the eagerly loaded results to their parents.
     * Override to ensure distinct results are properly matched.
     */
    public function match(array $models, Collection $results, $relation): array
    {
        // First deduplicate the results by primary key
        $results = $results->unique(function ($model) {
            return $model->getKey();
        })->values();

        // Then use parent's matching logic
        return parent::match($models, $results, $relation);
    }

    /**
     * Build model dictionary keyed by the relation's foreign key.
     * Override to work without pivot data by using the through table.
     */
    protected function buildDictionary(Collection $results): array
    {
        // For a "through" relationship, we need to query which parents
        // each result belongs to since we don't have pivot data
        $dictionary = [];

        // Get all the result IDs
        $resultIds = $results->pluck($this->relatedKey)->all();

        if (empty($resultIds)) {
            return $dictionary;
        }

        // Query the relationship to get parent-child mappings
        // Use a fresh query builder to avoid duplicate joins
        $mappings = $this->related->getConnection()
            ->table($this->table)
            ->join($this->throughTable, $this->table.'.'.$this->foreignPivotKey, '=', $this->throughTable.'.id')
            ->whereIn($this->table.'.'.$this->relatedPivotKey, $resultIds)
            ->select([
                $this->throughTable.'.'.$this->throughForeignKey.' as parent_key',
                $this->table.'.'.$this->relatedPivotKey.' as related_key',
            ])
            ->distinct()
            ->get();

        // Build dictionary from mappings
        foreach ($mappings as $mapping) {
            $parentKey = $this->getDictionaryKey($mapping->parent_key);
            $relatedKey = $mapping->related_key;

            // Find the result with this related key
            $result = $results->firstWhere($this->relatedKey, $relatedKey);

            if ($result && ! isset($dictionary[$parentKey])) {
                $dictionary[$parentKey] = [];
            }

            if ($result) {
                // Only add if not already in the dictionary (ensure distinct per parent)
                $alreadyAdded = false;
                foreach ($dictionary[$parentKey] as $existing) {
                    if ($existing->getKey() === $result->getKey()) {
                        $alreadyAdded = true;
                        break;
                    }
                }

                if (! $alreadyAdded) {
                    $dictionary[$parentKey][] = $result;
                }
            }
        }

        return $dictionary;
    }

    /**
     * Get the underlying query builder instance.
     * Override to ensure any direct query builder access also gets our constraints.
     */
    public function getQuery()
    {
        $query = parent::getQuery();

        // Apply DISTINCT only once to avoid issues with multiple getQuery() calls
        if (! $this->distinctApplied) {
            $this->distinctApplied = true;

            // When query is accessed directly (bypassing our get() method),
            // ensure deduplication by using DISTINCT
            // Remove GROUP BY and ensure we only select from related table
            $query->getQuery()->groups = null;
            $query->getQuery()->columns = null;
            $query->select($this->related->getTable().'.*');
            $query->distinct();

        }

        return $query;
    }

    /**
     * Get the base query builder driving the Eloquent builder.
     */
    public function toBase()
    {

        return parent::toBase();
    }

    /**
     * Apply distinct constraints to the query.
     */
    protected function applyDistinctConstraints(): void
    {
        $relatedTable = $this->related->getTable();

        // Get all columns for GROUP BY to satisfy MySQL ONLY_FULL_GROUP_BY
        $groupByColumns = $this->related->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($relatedTable);

        // Apply groupBy with all columns from the related table
        foreach ($groupByColumns as $column) {
            $this->query->groupBy("{$relatedTable}.{$column}");
        }
    }

    /**
     * Add the constraints for a relationship query.
     */
    public function getRelationExistenceQuery(Builder $query, Builder $parentQuery, $columns = ['*']): Builder
    {
        if ($parentQuery->getQuery()->from === $query->getQuery()->from) {
            return $this->getRelationExistenceQueryForSelfRelation($query, $parentQuery, $columns);
        }

        $this->performJoin($query);

        // Check if this is a count query (columns will be a COUNT expression)
        $isCountQuery = is_object($columns) &&
                       method_exists($columns, 'getValue') &&
                       str_contains(strtolower($columns->getValue($query->getGrammar())), 'count');

        if ($isCountQuery) {
            // For count queries, we need to use COUNT(DISTINCT ...)
            // Extract the column being counted (usually '*')
            $countExpression = $columns->getValue($query->getGrammar());

            // Replace count(*) with count(distinct related_table.id)
            $distinctCount = str_replace(
                'count(*)',
                'count(distinct '.$this->getQualifiedRelatedKeyName().')',
                $countExpression
            );

            $columns = new \Illuminate\Database\Query\Expression($distinctCount);
        }

        return $query->select($columns)->whereColumn(
            $this->throughTable.'.'.$this->throughForeignKey,
            '=',
            $this->getQualifiedParentKeyName()
        );
    }

    /**
     * Add the constraints for a relationship count query.
     */
    public function getRelationExistenceCountQuery(Builder $query, Builder $parentQuery): Builder
    {
        // Don't call getRelationExistenceQuery because it adds a select()
        // which interferes with our selectRaw()
        if ($parentQuery->getQuery()->from === $query->getQuery()->from) {
            return $this->getRelationExistenceQueryForSelfRelation($query, $parentQuery, ['*']);
        }

        $this->performJoin($query);

        // Clear any GROUP BY from the query as it interferes with COUNT
        $query->getQuery()->groups = null;

        // Use COUNT(DISTINCT) to count unique related records
        $result = $query
            ->selectRaw('COUNT(DISTINCT '.$this->getQualifiedRelatedKeyName().') as aggregate')
            ->whereColumn(
                $this->throughTable.'.'.$this->throughForeignKey,
                '=',
                $this->getQualifiedParentKeyName()
            );

        return $result;
    }

    /**
     * Execute the query as a "select" statement.
     */
    public function get($columns = ['*']): Collection
    {
        // Ensure we're only selecting related table columns
        if ($columns == ['*']) {
            $columns = [$this->related->getTable().'.*'];
        }

        $results = parent::get($columns);

        // The GROUP BY should have already ensured distinct results, but deduplicate as a safety measure
        $unique = $results->unique(function ($model) {
            return $model->getKey();
        })->values();

        return $unique;
    }

    /**
     * Get the count of the relationship.
     */
    public function count(): int
    {
        // Clone the query to avoid modifying the original
        $query = clone $this->query;

        // Clear any existing selects and group by to avoid interference
        $query->getQuery()->orders = null;
        $query->getQuery()->groups = null;
        $query->getQuery()->columns = null;

        // Use COUNT(DISTINCT) to count unique related records
        $result = $query
            ->selectRaw('COUNT(DISTINCT '.$this->getQualifiedRelatedKeyName().') as aggregate')
            ->first();

        return (int) ($result->aggregate ?? 0);
    }

    /**
     * Get the results of the relationship.
     * This is called when accessing the relationship as a dynamic property.
     */
    public function getResults(): Collection
    {
        return $this->get();
    }

    /**
     * Paginate the relationship.
     * Override to ensure items are properly deduplicated.
     */
    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
    {
        // Let the parent handle the pagination logic
        $paginator = parent::paginate($perPage, $columns, $pageName, $page, $total);

        // Get the items and ensure they're deduplicated
        $items = $paginator->items();
        $collection = $this->related->newCollection($items);
        $uniqueItems = $collection->unique(function ($model) {
            return $model->getKey();
        })->values()->all();

        // Replace the paginator's items with deduplicated ones
        // We need to create a new paginator with the correct count
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $uniqueItems,
            $paginator->total(),  // Keep the correct total
            $paginator->perPage(),
            $paginator->currentPage(),
            $paginator->getOptions()
        );
    }
}
