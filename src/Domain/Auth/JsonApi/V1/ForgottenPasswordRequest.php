<?php

namespace Dystore\Api\Domain\Auth\JsonApi\V1;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class ForgottenPasswordRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array<string,array>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
        ];
    }

    /**
     * Get the validation messages for the request.
     *
     * @return array<string,string>
     */
    public function messages(): array
    {
        return [
            'email.required' => __('dystore::validations.auth.email.required'),
            'email.string' => __('dystore::validations.auth.email.string'),
            'email.email' => __('dystore::validations.auth.email.email'),
            'email.max' => __('dystore::validations.auth.email.max'),
        ];
    }
}
