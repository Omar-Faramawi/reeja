<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ShwagherAuth
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
        if (in_array(Auth::user()->user_type_id, ['1', '5'])) {
            return abort(401);
        }
        
        return $next($request);
    }
}
