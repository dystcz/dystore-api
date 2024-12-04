<?php

namespace Dystore\Api\Domain\Users\JsonApi\V1;

use Dystore\Api\Domain\Users\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class CreateUserRequest extends ResourceRequest
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
                Rule::unique(User::class),
            ],
            'password' => [
                'required',
                'string',
                Password::min(8),
                'confirmed',
            ],
            // 'accept_terms' => [
            //     'required',
            //     'accepted',
            // ],
        ];
    }

    /**
     * Get the validation messages.
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
            'email.unique' => __('dystore::validations.auth.email.unique'),
            'password.required' => __('dystore::validations.auth.password.required'),
            'password.min' => __('dystore::validations.auth.password.min'),
            'password.string' => __('dystore::validations.auth.password.string'),
            'password.confirmed' => __('dystore::validations.auth.password.confirmed'),

            'accept_terms.required' => __('validation.auth.accept_terms.required'),
            'accept_terms.accepted' => __('validation.auth.accept_terms.accepted'),
        ];
    }
}
