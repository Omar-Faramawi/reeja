<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;

class Laborer
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
        //TODO: GET USER PERMISSIONS FROM DB
        $allowedUserTypes = array('3', '4', 'mol', '2');

        if(!in_array(session('auth.type'), $allowedUserTypes)){
            return abort(401);
        }

        return $next($request);
    }
}
