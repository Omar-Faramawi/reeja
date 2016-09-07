<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;
use Tamkeen\Ajeer\Models\Establishment;

class EstablishmentUpdated
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
        $responsible = Establishment::find(session()->get('selected_establishment.id'))->responsibles()->count();
        if (!$responsible) {
            return redirect()->url('establishment/update');
        }
        
        return $next($request);
    }
}
