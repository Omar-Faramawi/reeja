<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;

class IndvidualContractCancelation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session('auth.type') != '5'){
            return abort(401);
        }

        return $next($request);
    }
}