<?php

namespace Dystcz\LunarApi\Domain\Tags\JsonApi\V1;

use Dystcz\LunarApi\Domain\JsonApi\Eloquent\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\MorphTo;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Filters\WhereIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use Lunar\Models\Tag;

class TagSchema extends Schema
{
    /**
     * The default paging parameters to use if the client supplies none.
     */
    protected ?array $defaultPagination = ['number' => 1];

    /**
     * The model the schema corresponds to.
     */
    public static string $model = Tag::class;

    /**
     * Build an index query for this resource.
     */
    public function indexQuery(?Request $request, Builder $query): Builder
    {
        return $query;
    }

    /**
     * Build a "relatable" query for this resource.
     */
    public function relatableQuery(?Request $request, Relation $query): Relation
    {
        return $query;
    }

    /**
     * The relationships that should always be eager loaded.
     */
    public function with(): array
    {
        return [
            
        ];
    }

    /**
     * Get the include paths supported by this resource.
     *
     * @return string[]|iterable
     */
    public function includePaths(): iterable
    {
        return [
            
            // 'taggables',
        ];
    }

    /**
     * Get the resource fields.
     */
    public function fields(): array
    {
        return [
            

            ID::make(),

            Str::make('value'),

            // MorphTo::make('taggables', 'taggables')
            //     ->type('products'),
        ];
    }

    /**
     * Get the resource filters.
     */
    public function filters(): array
    {
        return [
            

            WhereIdIn::make($this)->delimiter(','),

            Where::make('value'),

            WhereIn::make('values', 'value')->delimiter(','),
        ];
    }

    /**
     * Get the resource paginator.
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make()
            ->withDefaultPerPage(
                Config::get('lunar-api.domains.tags.pagination', 12)
            );
    }

    /**
     * Determine if the resource is authorizable.
     */
    public function authorizable(): bool
    {
        return false; // TODO create policies
    }

    /**
     * Get the JSON:API resource type.
     */
    public static function type(): string
    {
        return 'tags';
    }
}