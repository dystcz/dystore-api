<?php

namespace Dystore\Api\Domain\Prices\Http\Middleware;

use Closure;
use Dystore\Api\Domain\Prices\Scopes\ApiPricingScope;
use Illuminate\Http\Request;
use Lunar\Models\Price;

class SetApiPricing
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Price::modelClass()::addGlobalScope(new ApiPricingScope);

        return $next($request);
    }
}
