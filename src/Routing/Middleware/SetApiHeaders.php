<?php

namespace Dystore\Api\Routing\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetApiHeaders
{
    /**
     * Handle an incoming request and always return json.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/vnd.api+json');

        return $next($request);
    }
}
