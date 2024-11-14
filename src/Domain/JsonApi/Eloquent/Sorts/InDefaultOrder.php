<?php

namespace Dystcz\LunarApi\Domain\JsonApi\Eloquent\Sorts;

use LaravelJsonApi\Eloquent\Contracts\SortField;

class InDefaultOrder implements SortField
{
    private string $name;

    private ?string $column = null;

    /**
     * Create a new sort field.
     */
    public static function make(string $name, ?string $column = null): self
    {
        return new static($name);
    }

    /**
     * CustomSort constructor.
     */
    public function __construct(string $name, ?string $column = null)
    {
        $this->name = $name;

        $this->column = $column;
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
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function sort($query, string $direction = 'asc')
    {
        if ($this->column) {
            return $query->orderBy($this->column, $direction);
        }

        if (method_exists($query, 'defaultOrder')) {
            /** @var \Kalnoy\Nestedset\QueryBuilder $query */
            return $query->defaultOrder();
        }

        if (method_exists($query, 'ordered')) {
            return $query->ordered();
        }

        return $query;
    }
}
