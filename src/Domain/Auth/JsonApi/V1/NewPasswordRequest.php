<?php

namespace Dystore\Api\Domain\Auth\JsonApi\V1;

use Illuminate\Validation\Rules\Password;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class NewPasswordRequest extends ResourceRequest
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
                'email',
            ],
            'token' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'string',
                Password::min(8),
                'confirmed',
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
            'email.required' => __('dystore::validations.users.email.required'),
            'email.email' => __('dystore::validations.users.email.email'),
            'token.required' => __('dystore::validations.users.token.required'),
            'token.string' => __('dystore::validations.users.token.string'),
            'password.min' => __('dystore::validations.users.password.min'),
            'password.required' => __('dystore::validations.users.password.required'),
            'password.string' => __('dystore::validations.users.password.string'),
            'password.confirmed' => __('dystore::validations.users.password.confirmed'),
        ];
    }
}
