<?php

namespace Dystore\Api\Tests\Stubs\JsonApi\V1;

use Dystore\Api\Domain\JsonApi\Servers\Server as BaseServer;
use Dystore\Api\Tests\Stubs\Users\JsonApi\V1\UserSchema;

class Server extends BaseServer
{
    /**
     * Get the server's list of schemas.
     */
    protected function allSchemas(): array
    {
        return [
            UserSchema::class,
        ];
    }
}
