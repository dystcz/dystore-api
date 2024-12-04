<?php

namespace Dystore\Api\Domain\Auth\JsonApi\V1;

use Dystore\Api\Domain\Users\Models\User;
use Illuminate\Validation\Rule;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class UserWithoutPasswordRequest extends ResourceRequest
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
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::modelClass()),
            ],
            'phone' => [
                'nullable',
                'phone',
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
            'name.string' => __('dystore::validations.users.name.string'),
            'name.max' => __('dystore::validations.users.name.max'),
            'email.required' => __('dystore::validations.users.email.required'),
            'email.string' => __('dystore::validations.users.email.string'),
            'email.email' => __('dystore::validations.users.email.email'),
            'email.max' => __('dystore::validations.users.email.max'),
            'email.unique' => __('dystore::validations.users.email.unique'),
            'phone.required' => __('dystore::validations.users.phone.required'),
            'phone.phone' => __('dystore::validations.users.phone.phone'),
        ];
    }
}
