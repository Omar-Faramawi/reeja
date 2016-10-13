<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tamkeen\Ajeer\Http\Controllers\Controller;

use Tamkeen\Ajeer\Http\Requests\ContractsRequest;
use Tamkeen\Ajeer\Http\Requests\ReceivedContractRequest;
use Tamkeen\Ajeer\Http\Requests\TaqawelContractRequest;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\Establishment;
use Tamkeen\Ajeer\Models\Individual;
use Tamkeen\Ajeer\Models\Government;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Reason;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\User;
use Tamkeen\Ajeer\Utilities\Constants;

/**
 * Class ContractsController
 * @package Tamkeen\Ajeer\Http\Controllers\Front
 */
class TaqawelContractController extends Controller
{
	/**
     * List Taqawerl contracts
     *
     * @return mixed
     */
    public function taqawelContractsList($type = 'provider')
    {
        $columns = request()->input('columns');
        if (request()->ajax()) {

            switch ($type) {
                case 'provider':
                    $data = Contract::with('contractEmployee.hrPool')->Status('benef_cancel')->ByMe()->Taqawel();
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

                case 'beneficial':
                    $data = Contract::with('contractEmployee.hrPool')->Status('provider_cancel')->ToMe()->Taqawel();
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
            if (request()->input('start_date')) {
                $data = $data->where('start_date', '>=', request()->input('start_date'));
            }
            if (request()->input('end_date')) {
                $data = $data->where('end_date', '<=', request()->input('end_date'));
            }

             $buttons = [
                'details' => [],
            ];

            $total_count = ($data->count()) ? $data->count() : 1;

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons);
        }

        return view("front.taqawel.contracts.cancellation.contracts.index");
    }

    /**
     * show single Taqawel contract
     *
     * @return mixed
     */
    public function singleTaqawelContract($type = 'provider', $id)
    {
        $contract = Contract::where('id', $id)->with('contractEmployee.hrPool', 'marketTaqawoulServices', 'contractNature')->firstOrFail();
        $reasons  = Reason::where('parent_id', 9)->get();

        return view('front.taqawel.contracts.cancellation.contracts.show', compact('contract', 'reasons'));
    }

    /**
     * List Taqawerl Ishaar
     *
     * @return mixed
     */
    public function taqawelIshaarsList($type = 'provider')
    {
        $columns = request()->input('columns');
        if (request()->ajax()) {
            switch ($type) {
                case 'provider':
                    $data = ContractEmployee::whereHas('contract', function ($query){
                        $query->byMe()->Taqawel();
                    })->where('status', 'benef_cancel')->with('contract','hrPool.job');
                    if (request()->input('name')) {
                            $data = $data->whereHas('hrPool', function($q){
                                $q->where('name', 'LIKE', '%' . request()->input('name') . '%');
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

                case 'beneficial':
                    $data = ContractEmployee::whereHas('contract', function ($query){
                        $query->toMe()->Taqawel();
                    })->where('status', 'provider_cancel')->with('contract','hrPool.job');
                     if (request()->input('name')) {
                           $data = $data->whereHas('hrPool', function($q){
                                $q->where('name', 'LIKE', '%' . request()->input('name') . '%');
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
            if (request()->input('start_date')) {
                $data = $data->where('start_date', '>=', request()->input('start_date'));
            }
            if (request()->input('end_date')) {
                $data = $data->where('end_date', '<=', request()->input('end_date'));
            }
            if (request()->input('job_name')) {
                $data = $data->whereHas('hrPool', function($query){
                    $query->whereHas('job', function($q){
                        $q->where('job_name', 'LIKE', '%' . request()->input('job_name') . '%');
                    });
                });
            }


             $buttons = [
                'details' => [],
            ];

            $total_count = ($data->count()) ? $data->count() : 1;

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons);

        }
        return view("front.taqawel.contracts.cancellation.ishaar.index");
    }

    /**
     * show single Taqawel Ishaar
     *
     * @return mixed
     */
    public function singleTaqawelIshaar($type = 'provider', $id)
    {
        $contractEmployee = ContractEmployee::where('id', $id)->with('contract', 'hrPool')->firstOrFail();
        $reasons  = Reason::where('parent_id', 10)->get();

        return view('front.taqawel.contracts.cancellation.ishaar.show', compact('contractEmployee', 'reasons'));
    }

     /**
     * accept Taqawel contract cancelation
     *
     * @return mixed
     */
    public function acceptTaqawelContractCancel(Request $request)
    {
        if (!$request->confirmed) {
            return response()->json(['error' => trans('contracts_cancelation.should_be_confirmed')],
                        422);
        } else {
            switch ($request->type) {
                case 'contract':
                    $contract = Contract::findOrFail($request->id);
                    $this->cascadeCancel($contract);

                    return trans('contracts_cancelation.accepted');

                case 'ishaar':
                    $ishaar = ContractEmployee::findOrFail($request->id);
                    $ishaar->status = 'cancelled';
                    $ishaar->save();

                    return trans('contracts_cancelation.accepted');
            }
        }
    }

     /**
     * refuse taqawel contract cancellation
     *
     * @return mixed
     */
    public function refuseTaqawelContractCancel(TaqawelContractRequest $request)
    {
        if ($request->reason != 'other') {
            //save selected reason
            switch ($request->type_r) {
                case 'contract':
                    $contract = Contract::findOrFail($request->id_r);
                    $contract->status = Constants::CONTRACT_STATUSES['approved'];
                    $contract->reason_id = $request->reason;
										if($request->details){
                      $contract->rejection_reason  = $request->details;
                    }
                    $contract->save();
                    return trans('contracts_cancelation.refused');
                    break;

                case 'ishaar':
                    $ishaar = ContractEmployee::findOrFail($request->id_r);
                    $ishaar->status = Constants::CONTRACT_STATUSES['approved'];
                    $ishaar->reasons_id = $request->reason;
                    if($request->details){
                            $ishaar->rejection_reason  = $request->details;
                    }
                    $ishaar->save();
                    return trans('contracts_cancelation.refused');
                    break;
            }

        } else {
            
                //save other reason
                switch ($request->type_r) {
                    case 'contract':
                        $contract = Contract::findOrFail($request->id_r);
                        $contract->status = Constants::CONTRACT_STATUSES['approved'];
                        $contract->other_reasons = $request->other;
                        if($request->details){
                                $contract->rejection_reason  = $request->details;
                        }
                        $contract->save();
                        return trans('contracts_cancelation.refused');
                        break;

                    case 'ishaar':
                        $ishaar = ContractEmployee::findOrFail($request->id_r);
                        $ishaar->status = Constants::CONTRACT_STATUSES['approved'];
                        $ishaar->other_reasons = $request->other;
                        if($request->details){
                          $ishaar->rejection_reason = $request->details;
                        }
                        $ishaar->save();
                        return trans('contracts_cancelation.refused');
                        break;
              
            }
        }
    }


     /**
     * cascade taqawel contract cancellation
     *
     * @return mixed
     */
    public function cascadeCancel(Contract $contract)
    {
        $contract->status = 'cancelled';
        $contract->save();
        ContractEmployee::where('contract_id', $contract->id)->update(['status' => 'cancelled']);
        $contract = Contract::where('contract_ref_no', $contract->id)->first();
        if($contract){
            $this->cascadeCancel($contract);
        }
    }
}
