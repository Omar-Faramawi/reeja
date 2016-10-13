<?php

namespace Tamkeen\Ajeer\Http\Middleware;

use Closure;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\Taqyeems;

class Rating
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
    	$user = getCurrentUserNameAndId();
    	
    	$contract = Contract::find($request->segment(3));
    	
    	if($contract->provider_id == $user[0] && $contract->provider_type == auth()->user()->user_type_id){

    		return $next($request);

    	}elseif($contract->benf_id == $user[0] && $contract->benf_type == auth()->user()->user_type_id){

    		return $next($request);

    	}else{

            return abort(401);
    	}
    }

}