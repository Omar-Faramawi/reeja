<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;

class Establishment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!in_array(auth()->user()->user_type_id, [3])) {
            return abort(401);
        }

        return $next($request);
    }

}
