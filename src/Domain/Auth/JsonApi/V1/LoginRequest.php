<?php

namespace Dystore\Api\Domain\Auth\JsonApi\V1;

use Dystore\Api\Facades\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use LaravelJsonApi\Laravel\Http\Requests\ResourceRequest;

class LoginRequest extends ResourceRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

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
            ],
            'password' => [
                'required',
                'string',
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
            'password.required' => __('dystore::validations.auth.password.required'),
            'password.string' => __('dystore::validations.auth.password.string'),
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! Auth::guard(Api::getAuthGuard())->attempt([
                'email' => $this->input('data.attributes.email'),
                'password' => $this->input('data.attributes.password'),
            ])) {
                $validator->errors()->add(
                    'password',
                    __('dystore::validations.auth.attempt.failed'),
                );
            }
        });
    }
}
