<?php

namespace Dystore\Api\Domain\JsonApi\Eloquent\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Kalnoy\Nestedset\QueryBuilder;
use LaravelJsonApi\Eloquent\Contracts\SortField;

/** @phpstan-consistent-constructor */
class InDefaultOrder implements SortField
{
    private string $name;

    private ?string $column = null;

    /**
     * CustomSort constructor.
     */
    public function __construct(string $name, ?string $column = null)
    {
        $this->name = $name;

        $this->column = $column;
    }

    /**
     * Create a new sort field.
     */
    public static function make(string $name, ?string $column = null): self
    {
        return new static($name);
    }

    /**
     * Get the name of the sort field.
     */
    public function sortField(): string
    {
        return $this->name;
    }

    /**
     * Apply the sort order to the query.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function sort($query, string $direction = 'asc')
    {
        if ($this->column) {
            return $query->orderBy($this->column, $direction);
        }

        if (method_exists($query, 'defaultOrder')) {
            /** @var QueryBuilder $query */
            return $query->defaultOrder();
        }

        if (method_exists($query, 'ordered')) {
            return $query->ordered();
        }

        return $query;
    }
}
