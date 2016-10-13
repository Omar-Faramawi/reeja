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
        if (auth()->user()->user_type_id == 3) {
            $responsible = Establishment::find(session()->get('selected_establishment.id'))->responsibles()->count();
            if (!$responsible) {
                return redirect()->route('establishment.profile.edit')->with(['msg' => trans('establishment.should_add_responsible'), 'status'=>'block alert-danger', 'red_url' => $request->path()]);
            }
        }
        
        return $next($request);
    }
}
