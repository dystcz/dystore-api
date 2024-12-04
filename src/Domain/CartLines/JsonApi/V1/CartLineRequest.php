<?php

namespace Dystore\Api\Domain\CartLines\JsonApi\V1;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class CartLineRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array<string,array<int,mixed>>
     */
    public function rules(): array
    {
        return [
            'quantity' => [
                'nullable',
                'integer',
            ],
            'purchasable_id' => [
                'required',
                'integer',
            ],
            'purchasable_type' => [
                'required',
                'string',
            ],
            'meta' => [
                'nullable',
                'array',
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
        return [
            'quantity.integer' => __('dystore::validations.cart_lines.quantity.integer'),
            'purchasable_id.required' => __('dystore::validations.cart_lines.purchasable_id.required'),
            'purchasable_id.integer' => __('dystore::validations.cart_lines.purchasable_id.integer'),
            'purchasable_type.required' => __('dystore::validations.cart_lines.purchasable_type.required'),
            'purchasable_type.string' => __('dystore::validations.cart_lines.purchasable_type.string'),
            'meta.array' => __('dystore::validations.cart_lines.meta.array'),
        ];
    }
}
