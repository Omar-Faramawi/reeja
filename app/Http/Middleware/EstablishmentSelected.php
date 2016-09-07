<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;

class EstablishmentSelected
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
        if (auth()->user()->user_type_id == 3 && !session()->has('selected_establishment')) {
            return redirect()->url('establishment');
        }
        return $next($request);
    }
}
