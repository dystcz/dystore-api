<?php

namespace Dystore\Api\Domain\Users\JsonApi\V1;

use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class UpdateUserRequest extends ResourceRequest
{
    /**
     * Get the validation rules for the resource.
     *
     * @return array<string,array>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'phone' => [
                'nullable',
                // 'phone',
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
            'name.string' => __('dystore::validation.users.name.string'),
            'name.max' => __('dystore::validation.users.name.max'),
            'first_name.required' => __('dystore::validation.users.first_name.required'),
            'first_name.string' => __('dystore::validation.users.first_name.string'),
            'first_name.max' => __('dystore::validation.users.first_name.max'),
            'last_name.required' => __('dystore::validation.users.last_name.required'),
            'last_name.string' => __('dystore::validation.users.last_name.string'),
            'last_name.max' => __('dystore::validation.users.last_name.max'),

            'email.required' => __('dystore::validations.auth.email.required'),
            'email.string' => __('dystore::validations.auth.email.string'),
            'email.email' => __('dystore::validations.auth.email.email'),
            'email.max' => __('dystore::validations.auth.email.max'),
            'email.unique' => __('dystore::validations.auth.email.unique'),
            'password.required' => __('dystore::validations.auth.password.required'),
            'password.min' => __('dystore::validations.auth.password.min'),
            'password.string' => __('dystore::validations.auth.password.string'),
            'password.confirmed' => __('dystore::validations.auth.password.confirmed'),

            'phone.required' => __('dystore::validations.auth.phone.required'),
            'phone.phone' => __('dystore::validations.auth.phone.phone'),
        ];
    }
}
