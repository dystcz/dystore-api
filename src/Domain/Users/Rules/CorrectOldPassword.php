<?php

namespace Dystore\Api\Domain\Users\Rules;

use Closure;
use Dystore\Api\Domain\Users\Contracts\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class CorrectOldPassword implements ValidationRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    public function __construct(protected User $user) {}

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Hash::check($value, $this->user->password)) {
            $fail(__('validation.users.old_password.correct'));
        }
    }
}
