<?php

namespace Dystore\Api\Domain\ProductVariants\JsonApi\Filters;

use LaravelJsonApi\Eloquent\Contracts\Filter;
use LaravelJsonApi\Eloquent\Filters\Concerns\DeserializesValue;
use LaravelJsonApi\Eloquent\Filters\Concerns\HasDelimiter;
use LaravelJsonApi\Eloquent\Filters\Concerns\IsSingular;

/** @phpstan-consistent-constructor */
class WhereProductOptionValueSlugs implements Filter
{
    use DeserializesValue;
    use HasDelimiter;
    use IsSingular;

    private readonly string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Create a new filter.
     *
     * @return static
     */
    public static function make(string $name): self
    {
        return new static($name);
    }

    /**
     * {@inheritDoc}
     */
    public function key(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function apply($query, $value)
    {
        $values = $this->deserialize($value);

        foreach ($values as $value) {
            $query->whereHas(
                'values',
                fn ($query) => $query->whereHas(
                    'defaultUrl',
                    fn ($query) => $query->where('slug', $value)
                )
            );
        }

        return $query;
    }

    /**
     * Deserialize the fitler value.
     *
     * @param  string|array  $value
     */
    protected function deserialize($value): array
    {
        if ($this->deserializer) {
            return ($this->deserializer)($value);
        }

        return $this->toArray($value);
    }
}
