<?php

namespace Dystore\Api\Domain\Storefront\JsonApi\V1;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;
use LaravelJsonApi\Validation\Rule as JsonApiRule;

class StorefrontRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array<string,array<int,mixed>>
     */
    public function rules(): array
    {
        return [
            'channel' => [
                'nullable',
                JsonApiRule::toOne(),
            ],
            'customer' => [
                'nullable',
                JsonApiRule::toOne(),
            ],
            'currency' => [
                'nullable',
                JsonApiRule::toOne(),
            ],
            'customer_groups' => [
                'nullable',
                JsonApiRule::toMany(),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [];
    }
}
