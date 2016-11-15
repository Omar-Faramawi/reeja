<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;

class EstablishmentSelected
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
        if (auth()->user()->user_type_id == 3 && empty(session()->has('selected_establishment'))) {
            return redirect()->route('establishment.select')->with('est_status', trans('establishment.please_select_est'));
        }
        if (auth()->user()->user_type_id == 5) {
            abort(401);
        }
        
        return $next($request);
    }
}
