<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;
use Tamkeen\Ajeer\Models\Establishment;
use Tamkeen\Ajeer\Models\Government;

class GovernmentUpdated
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
        if (auth()->user()->user_type_id == 2) {
            $responsible = Government::find(session()->get('government.id'))->responsibles()->count();
            if (!$responsible) {
                return redirect()->route('government.profile.edit')->with(['msg' => trans('gov_profile.should_add_responsible'), 'status'=>'block alert-danger', 'red_url' => $request->path()]);
            }
        }
        
        return $next($request);
    }
}
