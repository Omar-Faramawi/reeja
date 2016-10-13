<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tamkeen\Ajeer\Http\Controllers\Controller;

use Tamkeen\Ajeer\Http\Requests\RatingRequest;

use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\User;
use Tamkeen\Ajeer\Models\RatingModels;
use Tamkeen\Ajeer\Models\Taqyeems;
use Tamkeen\Ajeer\Models\TaqyeemDtl;
use Tamkeen\Ajeer\Models\TaqyeemTemplatePermission;
use Tamkeen\Ajeer\Models\PermissionServiceEnviroment;

use Tamkeen\Ajeer\Utilities\Constants;

/**
 * Class Rating Controller
 * @package Tamkeen\Ajeer\Http\Controllers\Front
 */
class RatingController extends Controller
{
	 /**
     * Show list if contracts and rating model.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($taqyeemId, $type = 'provider')
    {
     	$today = Carbon::today();
     	$templatePermission = TaqyeemTemplatePermission::where('taqyeem_template_id', $taqyeemId)->firstOrFail();

     	/** Check if Taqyeem is Ajeer Gate Rating */
		if($templatePermission->taqyeem_type == '2'){
			return $this->ajeerGateRating($templatePermission);
		}     	

     	$columns = request()->input('columns');
     	if (request()->ajax()) {
     		switch($type)
     		{
     			case 'provider'   :
     				$permisionServices  = PermissionServiceEnviroment::where('template_permission_id', $templatePermission->id)
     													 			 ->where('provider', 1)->pluck('contract_type_id');
					$data = Contract::byMe()->approved()->whereIn('contract_type_id', $permisionServices)->where('end_date' ,'<=', $today)
                                            ->whereRaw('CURDATE() <= ( end_date + INTERVAL '.$templatePermission->link_period.' DAY )');
                               
					 if (request()->input('name')) {
                        $data = $data->where(function ($provider_q) {
                            $provider_q->whereHas('benfEstablishment', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name') . '%');
                            });
                            $provider_q->orWhereHas('benfIndividual', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name') . '%');
                            });
                            $provider_q->orWhereHas('benfGovernment', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name') . '%');
                            });
                        });
                    }
                    if (request()->input('name2')) {
                        $data = $data->where(function ($provider_q) {
                            $provider_q->whereHas('establishment', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name2') . '%');
                            });
                            $provider_q->orWhereHas('individual', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name2') . '%');
                            });
                            $provider_q->orWhereHas('government', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name2') . '%');
                            });

                        });
                    }
     				break;
     			case 'beneficial' :
     				$permisionServices  = PermissionServiceEnviroment::where('template_permission_id', $templatePermission->id)
     													 			 ->where('benf', 1)->pluck('contract_type_id');
					$data = Contract::toMe()->approved()->whereIn('contract_type_id', $permisionServices)->where('end_date', '<=', $today)
                    ->whereRaw('CURDATE() <= ( end_date + INTERVAL '.$templatePermission->link_period.' DAY )');;
					if (request()->input('name')) {
                        $data = $data->where(function ($provider_q) {
                            $provider_q->whereHas('establishment', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name') . '%');
                            });
                            $provider_q->orWhereHas('individual', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name') . '%');
                            });
                            $provider_q->orWhereHas('government', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name') . '%');
                            });

                        });
                    }
                    if (request()->input('name2')) {
                        $data = $data->where(function ($provider_q) {
                            $provider_q->whereHas('benfEstablishment', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name2') . '%');
                            });
                            $provider_q->orWhereHas('benfIndividual', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name2') . '%');
                            });
                            $provider_q->orWhereHas('benfGovernment', function ($est_q) {
                                $est_q->where('name', 'LIKE', '%' . request()->input('name2') . '%');
                            });
                        });
                    }
     				break;
     		}
     		
     		if (request()->input('id')) {
                $data = $data->where('id', request()->input('id'));
            }

     		$buttons = [
                'Details' => [
                    "text"       => trans("rating.rating_button"),
                    "url"        => url("rating/".$taqyeemId),
                    "uri"        => "rate",
                    "css_class"  => "blue",
                    "attributes" => [
                        "data-token" => csrf_token(),
                    ],
                ],
            ];

            $total_count = ($data->count()) ? $data->count() : 1;

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons);
     	}

     	return view('front.rating.index');
    }

     /**
     * Show Taqyeem items for rating
     *
     * @return \Illuminate\Http\Response
     */
    public function show($taqyeemId, $contractId)
    {
        $contract = Contract::find($contractId);
     	$user = getCurrentUserNameAndId();

     	$taqyeem = Taqyeems::where('taqyeem_template_id', $taqyeemId)
     					   ->where('contract_id', $contractId)
     					   ->where('owner_type', auth()->user()->user_type_id)
     					   ->where('owner_id', $user[0])->get();
     	
     	if(count($taqyeem) > 0){
     		$taqyeemTaken = 1;
     	}


     	$templatePermission = TaqyeemTemplatePermission::where('taqyeem_template_id', $taqyeemId)->firstOrFail();
     	if($templatePermission->taqyeem_type != '1'){
     		$block = 1;
     	}
     	$createAt = Carbon::createFromTimestamp(strtotime($contract->end_date));
     	$endOfLinkPeriod = $createAt->addDay($templatePermission->link_period);
     	$today = Carbon::now();
     	if($endOfLinkPeriod < $today){
     		$outdated = 1;
     	}

     	$permisionServices = PermissionServiceEnviroment::where('template_permission_id', $templatePermission->id)
     												    ->where('contract_type_id', $contract->contract_type_id)->firstOrFail();
     	if($contract->benf_type == auth()->user()->user_type_id && $contract->benf_id == $user[0]){
     		$type = "beneficial";
     		if($permisionServices->benf == '0'){
     			$block = 1;
     		}
     	}else if($contract->provider_type == auth()->user()->user_type_id && $contract->provider_id == $user[0]){
     		if($permisionServices->provider == '0'){
     			$block = 1;
     		}
     		$type = "";
     	}
     	$taqyeem = RatingModels::with('items.degrees')->where('id', $taqyeemId)->firstOrFail();
     	
     	return view('front.rating.show', compact('taqyeem', 'contractId', 'taqyeemTaken', 'type', 'block', 'outdated'));
    }

	/**
     * store rating degrees
     *
     * @return \Illuminate\Http\Response
     */
    public function postRating(RatingRequest $request)
    {
     	$data = $request->only(array_keys($request->rules()));

     	$contract = Contract::find($request->get('contractId'));	

     	$taqyeem = new Taqyeems();

     	if(session()->get('selected_establishment')){
     		$taqyeem->owner_id = session()->get('selected_establishment.id');
     	}else if(session()->get('government')){
     		$taqyeem->owner_id = session()->get('government.id');
     	}else{
     		$taqyeem->owner_id = auth()->user()->id_no;
     	}

     	$taqyeem->owner_type = auth()->user()->user_type_id;
     	$taqyeem->status = '0';

     	if($request->get('contractId') == 0){
     		/** Ajeer Gate rating */
     		$taqyeem->contract_id = 'NULL';
     		$taqyeem->benf_type = "0";
     		$taqyeem->benf_id = 0;
     	}else{
     		$taqyeem->contract_id = $request->get('contractId');

	     	if($contract->benf_type == $taqyeem->owner_type && $contract->benf_id == $taqyeem->owner_id){
	     		$taqyeem->benf_type = $contract->provider_type;
	     		$taqyeem->benf_id = $contract->provider_id;
	     	}else{
		     	$taqyeem->benf_type = $contract->benf_type;
		     	$taqyeem->benf_id = $contract->benf_id;
	     	}
     	}

     	$taqyeem->taqyeem_template_id = $request->get('taqyeemId');
     	$taqyeem->save();

     	$template = RatingModels::find($request->get('taqyeemId'));
     	$items 	  = $template->taqyeemTemplateItems;
     	
     	for($i = 0; $i < count($items); $i++){
     		$taqyeemDtl        		 			   = new TaqyeemDtl();
     		$taqyeemDtl->taqyeems_id 			   = $taqyeem->id;
     		$taqyeemDtl->degrees_id  			   = $data['name'][$i];
     		$taqyeemDtl->taqyeem_template_items_id = $items[$i]->id;
     		$taqyeemDtl->save();
     	}
     	
     	return trans('rating.added');
    }

     /**
     * show Gate Rating
     *
     * @return \Illuminate\Http\Response
     */
    public function ajeerGateRating(TaqyeemTemplatePermission $templatePermission)
    {
    	$user = getCurrentUserNameAndId();

    	if($templatePermission->residents == "2"){
	    	$allowed = $templatePermission->whereHas('PermissionSpecificUsers', function($query) use ($user){
	    		$query->where('user_type', auth()->user()->user_type_id)->where('user_id', $user[0]);
	    	})->get();
	    	$allowed = count($allowed);
    	}elseif($templatePermission->residents == "1"){
    		$allowed == 1;
    	}else{
    		$allowed = -1;
    	}

    	if($allowed > 0){
		    $taqyeem = Taqyeems::where('taqyeem_template_id', $templatePermission->taqyeem_template_id)
	     					   ->where('owner_type', auth()->user()->user_type_id)
	     			           ->where('owner_id', $user[0])->get();
	     	
			if(count($taqyeem) > 0){
				$taqyeemTaken = 1;
			}

    		switch ($templatePermission->periodic_or_date) {
	    		case '1':
	    			$createAt = Carbon::createFromTimestamp(strtotime($templatePermission->created_at));
			     	$endOfLinkPeriod = Carbon::createFromTimestamp(strtotime($templatePermission->created_at))->addDay($templatePermission->link_period);
			     	$now = Carbon::now();
			     	
			     	$length = $createAt->diffInMonths($now);
			     	
			    	if($length != 0 && $length % $templatePermission->periodic_period != 0){
			    		$block = 1;
			    	}
			     	$createAt->addMonth($length);
			     	$endOfLinkPeriod->addMonth($length);
			     	
			     	if(($now > $createAt || $now == $createAt) && ($now < $endOfLinkPeriod || $now == $endOfLinkPeriod))
			     	{
			     		$outdated = 0;
			     	}else{
			     		$outdated = 1;
			     	}

	    			break;
	    		
	    		case '2':
				    $taqyeemDate = Carbon::createFromTimestamp(strtotime($templatePermission->taqyeem_date));
				    $endOfLinkPeriod = $taqyeemDate->addDay($templatePermission->link_period);
				    $today = Carbon::now();
				    if($endOfLinkPeriod < $today){
				    	$outdated = 1;
				    }
	    			break;
    		}
    	}else{
    		$block = 1;
    	}

    	$taqyeem = RatingModels::with('items.degrees')->where('id', $templatePermission->taqyeem_template_id)->firstOrFail();
    	return view('front.rating.gate', compact('taqyeem', 'taqyeemTaken', 'block', 'outdated'));
    }
}