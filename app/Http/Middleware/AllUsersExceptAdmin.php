<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tamkeen\Ajeer\Models\Establishment;

class AllUsersExceptAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Authenticated user
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        } elseif(Auth::user()->user_type_id == '1') {  // Don't allow access if Admin user
            session()->forget('selected_establishment');
            session()->flush();

            return redirect('login');
        }

        // Establishment selected
        if (auth()->user()->user_type_id == 3 && empty(session()->has('selected_establishment'))) {
            return redirect()->route('establishment.select')->with('est_status', trans('establishment.please_select_est'));
        }

        // Establishment updated
        if (auth()->user()->user_type_id == 3) {
            $responsible = Establishment::find(session()->get('selected_establishment.id'))->responsibles()->count();
            if (!$responsible) {
                return redirect()->route('establishment.profile.edit')->with(['msg' => trans('establishment.should_add_responsible'), 'status'=>'block alert-danger', 'red_url' => $request->path()]);
            }
        }

        return $next($request);
    }
}
