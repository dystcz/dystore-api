<?php

namespace Dystore\Api\Domain\Auth\JsonApi\V1;

use Dystore\Api\Domain\Auth\JsonApi\Proxies\AuthUser;
use Dystore\Api\Domain\JsonApi\Eloquent\ProxySchema;
use Dystore\Api\Domain\Users\JsonApi\V1\UserSchema;
use Illuminate\Support\Facades\App;
use LaravelJsonApi\Eloquent\Fields\ArrayHash;

class AuthSchema extends ProxySchema
{
    /**
     * The model the schema corresponds to.
     */
    public static string $model = AuthUser::class;

    /**
     * {@inheritDoc}
     */
    public static function type(): string
    {
        return 'auth';
    }

    /**
     * Get the resource fields.
     */
    public function fields(): array
    {
        $userSchema = App::make(UserSchema::class);

        return [
            ...$userSchema->fields(),

            ArrayHash::make('data'),

            ...parent::fields(),
        ];
    }

    /**
     * Determine if the resource is authorizable.
     */
    public function authorizable(): bool
    {
        return false;
    }
}
