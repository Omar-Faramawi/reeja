<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;
use Tamkeen\Ajeer\Utilities\Constants;

class HajjGovernment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session('government.hajj') != '1') {
            return abort(401);
        }

        return $next($request);
    }
}
