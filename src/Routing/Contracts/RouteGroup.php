<?php

namespace Dystore\Api\Routing\Contracts;

interface RouteGroup
{
    /**
     * Register routes.
     */
    public static function make(string $prefix = '', array|string $middleware = []): self;

    /**
     * Register routes.
     */
    public function routes(): void;
}
