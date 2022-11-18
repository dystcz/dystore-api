<?php

namespace Dystcz\LunarApi\Domain\JsonApi\Builders;

use Spatie\QueryBuilder\QueryBuilder;

abstract class JsonApiBuilder
{
    use Concerns\HasFields;
    use Concerns\HasSorts;
    use Concerns\HasFilters;
    use Concerns\HasIncludes;
    use Concerns\HasUtils;
    use Concerns\CreatesSchemas;

    /**
     * Model class the builder is for.
     */
    public static string $model;

    /**
     * Model's schema.
     */
    public static string $schema;

    /**
     * Prepare default query with JsonApi parameters.
     */
    public function query(): QueryBuilder
    {
        return QueryBuilder::for(static::$model)
            ->allowedFields($this->fields())
            ->allowedSorts($this->sorts())
            ->allowedFilters($this->filters())
            ->allowedIncludes($this->includes());
    }
}