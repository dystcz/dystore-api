<?php

namespace Dystore\Api\Domain\CollectionGroups\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Queries\CollectionQuery;

class CollectionGroupCollectionQuery extends CollectionQuery
{
    /**
     * Get the validation rules that apply to the request query parameters.
     *
     * @return array<string,array<int,mixed>>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            ...parent::messages(),
        ];
    }
}
