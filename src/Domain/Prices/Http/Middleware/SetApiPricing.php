<?php

namespace Dystore\Api\Domain\Prices\Http\Middleware;

use Closure;
use Dystore\Api\Domain\Prices\Scopes\ApiPricingScope;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lunar\Models\Price;

class SetApiPricing
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response|RedirectResponse)  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Price::modelClass()::addGlobalScope(new ApiPricingScope);

        return $next($request);
    }
}
