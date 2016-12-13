<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tamkeen\Ajeer\Http\Controllers\Controller;

use Tamkeen\Ajeer\Http\Requests\ContractsRequest;
use Tamkeen\Ajeer\Http\Requests\ReceivedContractRequest;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\Establishment;
use Tamkeen\Ajeer\Models\Individual;
use Tamkeen\Ajeer\Models\Government;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Reason;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Invoice;
use Tamkeen\Ajeer\Models\ContractCertificate;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\User;
use Tamkeen\Ajeer\Utilities\Constants;
use Tamkeen\Platform\Billing\Connectors\Connector;
use Tamkeen\Ajeer\Models\ContractSetup;
use Carbon\Carbon;
use Tamkeen\Ajeer\Http\Requests\ContractCertificateRequest;
use Illuminate\Support\Facades\Auth;
/**
 * Class ContractsController
 * @package Tamkeen\Ajeer\Http\Controllers\Front
 */
class ContractsController extends Controller
{
    public function benfCancel($id)
    {
        list($userId, $username) = getCurrentUserNameAndId();

        try {
            if (session()->get('service_type') == Constants::SERVICETYPES['benf']) {
                $contract = Contract::toMe()->with('vacancy.job', 'vacancy.nationality')->findOrFail($id);
                if ($contract->contract_type_id == Constants::CONTRACTTYPES['direct_emp'] && $contract->status == Constants::CONTRACT_STATUSES['pending']) {
                    $status = Constants::CONTRACT_STATUSES['cancelled'];
                } else {
                    $status = Constants::CONTRACT_STATUSES['benef_cancel'];
                }
            } else {
                $contract = Contract::byMe()->with('vacancy.job', 'vacancy.nationality')->findOrFail($id);
                if ($contract->contract_type_id != Constants::CONTRACTTYPES['direct_emp'] && $contract->status == Constants::CONTRACT_STATUSES['pending']) {
                    $status = Constants::CONTRACT_STATUSES['cancelled'];
                } else {
                    $status = Constants::CONTRACT_STATUSES['provider_cancel'];
                }
            }
            $reasons = Reason::forTempWorkCancel()->pluck('reason', 'id')->toArray();

            if ($contract->status == "pending" || $contract->status == "approved") {
                $canCancel = true;
            } else {
                $canCancel = false;
            }

        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        

        return view('front.contracts.details',
            compact('userId', 'username', 'contract', 'canCancel', 'reasons', 'status'));

    }

    public function rejectRequest($id)
    {
        try {
            $contract = Contract::byMe()->with('vacancy.job', 'vacancy.nationality')->findOrFail($id);
            $reasons = Reason::forTempWorkCancel()->pluck('reason', 'id')->toArray();

            $reasonLabel = 'contracts.cancel_reason';
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        $status = 'rejected';

        return view('front.contracts.details',
            compact('contract', 'reasons', 'status', 'reasonLabel'));

    }

    public function updateStatus(ContractsRequest $request)
    {
        $contract = Contract::findOrFail($request->id);
        $data = $request->only(array_keys($request->rules()));

        if ($contract->contract_type_id != Constants::CONTRACTTYPES['direct_emp'] && ($data['status'] == 'provider_cancel' || $data['status'] == 'benef_cancel')) {
            $contractSetup = ContractSetup::where('contract_type_id', $contract->contract_type_id)->firstOrFail();
            if ($data['status'] == 'provider_cancel' && !$contractSetup->benf_cancel_contract) {
                $data['status'] = 'cancelled';
            } elseif ($data['status'] == 'benef_cancel' && !$contractSetup->provider_cancel_contract) {
                $data['status'] = 'cancelled';
            }
        }
        
        try {
            $contract->update($data);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return trans('contracts.updated');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function CancelResetContract($id)
    {
        if (session()->get('service_type') == Constants::SERVICETYPES['benf']) {
            $contract = Contract::toMe()->status(Constants::CONTRACT_STATUSES['benef_cancel'])->findOrFail($id);
        } else {
            $contract = Contract::byMe()->status(Constants::CONTRACT_STATUSES['provider_cancel'])->findOrFail($id);
        }
        $contract->status = Constants::CONTRACT_STATUSES['approved'];

        if ($contract->save()) {
            return trans('tqawel_offer_contract.cancel_reject_success');
        } else {
            return abort(401);
        }
    }
    
    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse|string|\Symfony\Component\Translation\TranslatorInterface
     *
     * Delete contract by ID
     */
    public function destroy($id)
    {
        try {
            $contract = Contract::byMe()->findOrFail($id);
            $contract->delete();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return trans('labels.deleted');

    }

    /**
     * show contracts
     *
     * @return mixed
     */
    public function showContracts($type = 'provider')
    {

        $columns = request()->input('columns');
        if (request()->ajax()) {

            switch ($type) {
                case 'provider':
                    $data = Contract::with('contractEmployee.hrPool')->where('status',
                        'benef_cancel')->ByMe()->HireLabor();
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
                    $data = Contract::with('contractEmployee.hrPool')->where('status',
                        'provider_cancel')->ToMe()->HireLabor();
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

        return view('front.contracts.cancelation.hire_labor.contract.index');
    }

    /**
     * show contract ishaar
     *
     * @return mixed
     */
    public function showIshaar($type = 'provider')
    {
        $columns = request()->input('columns');
        if (request()->ajax()) {
            switch ($type) {
                case 'provider':
                    $data = ContractEmployee::whereHas('contract', function ($query) {
                        $query->byMe()->HireLabor();
                    })->where('status', 'benef_cancel')->with('contract', 'hrPool.job');
                    if (request()->input('name')) {
                        $data = $data->whereHas('hrPool', function ($q) {
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
                    $data = ContractEmployee::whereHas('contract', function ($query) {
                        $query->toMe()->HireLabor();
                    })->where('status', 'provider_cancel')->with('contract', 'hrPool.job');
                    if (request()->input('name')) {
                        $data = $data->whereHas('hrPool', function ($q) {
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
                $data = $data->whereHas('hrPool', function ($query) {
                    $query->whereHas('job', function ($q) {
                        $q->where('id', '=', intval(request()->input('job_name')));
                    });
                });
            }

            $buttons = [
                'details' => [],
            ];

            $total_count = ($data->count()) ? $data->count() : 1;

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons);

        }
        $jobs = Job::pluck('job_name', 'id');

        return view('front.contracts.cancelation.hire_labor.ishaar.index', compact('jobs'));
    }

    /**
     * show single contract
     *
     * @return mixed
     */
    public function showSingleContract($type = 'provider', $id)
    {
        $contract = Contract::where('id', $id)->with('contractEmployee.hrPool', 'vacancy')->firstOrFail();
        $reasons  = Reason::where('parent_id', 7)->get();

        return view('front.contracts.cancelation.hire_labor.contract.show', compact('contract', 'reasons'));
    }

    /**
     * show single ishaar
     *
     * @return mixed
     */
    public function showSingleIshaar($type = 'provider', $id)
    {
        $contractEmployee = ContractEmployee::where('id', $id)->with('contract', 'hrPool')->firstOrFail();
        $reasons  = Reason::where('parent_id', 8)->get();

        return view('front.contracts.cancelation.hire_labor.ishaar.show', compact('contractEmployee', 'reasons'));

    }

    /**
     * refuse contract cancelation
     *
     * @return mixed
     */
    public function refuseCancel(Request $request)
    {
        if ($request->reason != 'other') {
            //save selected reason
            switch ($request->type_r) {
                case 'contract':
                    $contract = Contract::findOrFail($request->id_r);
                    $contract->status = 'approved';
                    $contract->reason_id = $request->reason;
                    if($request->details){
                      $contract->rejection_reason  = $request->details;
                    }
                    $contract->save();

                    return trans('contracts_cancelation.refused');
                    break;

                case 'ishaar':
                    $ishaar = ContractEmployee::findOrFail($request->id_r);
                    $ishaar->status = 'approved';
                    $ishaar->reasons_id = $request->reason;
                    if($request->details){
                      $ishaar->rejection_reason  = $request->details;
                    }
                    $ishaar->save();

                    return trans('contracts_cancelation.refused');
                    break;
            }

        } else {
            if (!$request->other) {
                throw new Exception;
            } else {
                //save other reason
                switch ($request->type_r) {
                    case 'contract':
                        $contract = Contract::findOrFail($request->id_r);
                        $contract->status = 'approved';
                        $contract->other_reasons = $request->other;
                        if($request->details){
                          $contract->rejection_reason  = $request->details;
                        }
                        $contract->save();

                        return trans('contracts_cancelation.refused');
                        break;

                    case 'ishaar':
                        $ishaar = ContractEmployee::findOrFail($request->id_r);
                        $ishaar->status = 'approved';
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
    }

    /**
     * accept contract cancelation
     *
     * @return mixed
     */
    public function acceptCancel(Request $request)
    {
        if (!$request->confirmed) {
            throw new Exception;
        } else {
            switch ($request->type) {
                case 'contract':
                    $contract = Contract::findOrFail($request->id);
                    $contract->status = 'cancelled';
                    $contract->save();
                    ContractEmployee::where('contract_id', $request->id)->update(['status' => 'cancelled']);

                    return trans('contracts_cancelation.accepted');
                    break;

                case 'ishaar':
                    $ishaar = ContractEmployee::findOrFail($request->id);
                    $ishaar->status = 'cancelled';
                    $ishaar->save();

                    return trans('contracts_cancelation.accepted');
                    break;
            }
        }
    }

    /**
     * show contracts of direct hiring
     *
     * @return mixed
     */
    public function show_direct_hiring_contracts($type = 'provider')
    {
        $columns = request()->input('columns');
        if (request()->ajax()) {

            switch ($type) {
                case 'provider':
                    $data = Contract::with('contractEmployee.hrPool')->where('status',
                        'benef_cancel')->ByMe()->DirectEmp();
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
                    $data = Contract::with('contractEmployee.hrPool')->where('status',
                        'provider_cancel')->ToMe()->DirectEmp();
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

        return view('front.contracts.cancelation.direct_hiring.contract.index');
    }

    /**
     * show contract ishaar of direct hiring
     *
     * @return mixed
     */
    public function show_direct_hiring_contracts_ishaar($type = 'provider')
    {
        $columns = request()->input('columns');
        if (request()->ajax()) {
            switch ($type) {
                case 'provider':
                    $data = ContractEmployee::whereHas('contract', function ($query) {
                        $query->byMe()->DirectEmp();
                    })->where('status', 'benef_cancel')->with('contract', 'hrPool.job');
                    if (request()->input('name')) {
                        $data = $data->whereHas('hrPool', function ($q) {
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
                    $data = ContractEmployee::whereHas('contract', function ($query) {
                        $query->toMe()->DirectEmp();
                    })->where('status', 'provider_cancel')->with('contract', 'hrPool.job');
                    if (request()->input('name')) {
                        $data = $data->whereHas('hrPool', function ($q) {
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
                $data = $data->whereHas('hrPool', function ($query) {
                    $query->whereHas('job', function ($q) {
                        $q->where('id', '=', intval(request()->input('job_name')));
                    });
                });
            }

            $buttons = [
                'details' => [],
            ];

            $total_count = ($data->count()) ? $data->count() : 1;

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons);

        }
        $jobs = Job::pluck('job_name', 'id');

        return view('front.contracts.cancelation.direct_hiring.ishaar.index', compact('jobs'));
    }

    /**
     * show single contract of direct hiring
     *
     * @return mixed
     */
    public function show_direct_hiring_single_contract($type = 'provider', $id)
    {
        $contract = Contract::where('id', $id)->with('contractEmployee.hrPool', 'vacancy')->firstOrFail();
        $reasons  = Reason::where('parent_id', 7)->get();

        return view('front.contracts.cancelation.direct_hiring.contract.show', compact('contract', 'reasons'));
    }

    /**
     * show single ishaar of direct hiring
     *
     * @return mixed
     */
    public function show_direct_hiring_contracts_single_ishaar($type = 'provider', $id)
    {
        $contractEmployee = ContractEmployee::where('id', $id)->with('contract', 'hrPool')->firstOrFail();
        $reasons  = Reason::where('parent_id', 8)->get();

        return view('front.contracts.cancelation.direct_hiring.ishaar.show', compact('contractEmployee', 'reasons'));
    }

    /**
     * accept contract cancelation
     *
     * @return mixed
     */
    public function accept_direct_hiring_contract_cancelation(Request $request)
    {
        if (!$request->confirmed) {
            throw new Exception;
        } else {
            switch ($request->type) {
                case 'contract':
                    $contract = Contract::findOrFail($request->id);
                    $contract->status = 'cancelled';
                    $contract->save();
                    ContractEmployee::where('contract_id', $request->id)->update(['status' => 'cancelled']);

                    return trans('contracts_cancelation.accepted');
                    break;

                case 'ishaar':
                    $ishaar = ContractEmployee::findOrFail($request->id);
                    $ishaar->status = 'cancelled';
                    $ishaar->save();
                    Contract::where('id', $ishaar->contract_id)->update(['status' => 'cancelled']);

                    return trans('contracts_cancelation.accepted');
                    break;
            }
        }
    }

    /**
     * refuse contract cancelation
     *
     * @return mixed
     */
    public function refuse_direct_hiring_contract_cancelation(Request $request)
    {
        if ($request->reason != 'other') {
            //save selected reason
            switch ($request->type_r) {
                case 'contract':
                    $contract = Contract::findOrFail($request->id_r);
                    $contract->status = 'approved';
                    $contract->reason_id = $request->reason;
                    if($request->details){
                      $contract->rejection_reason  = $request->details;
                    }
                    $contract->save();

                    return trans('contracts_cancelation.refused');
                    break;

                case 'ishaar':
                    $ishaar = ContractEmployee::findOrFail($request->id_r);
                    $ishaar->status = 'approved';
                    $ishaar->reasons_id = $request->reason;
                    if($request->details){
                      $ishaar->rejection_reason  = $request->details;
                    }
                    $ishaar->save();

                    return trans('contracts_cancelation.refused');
                    break;
            }

        } else {
            if (!$request->other) {
                throw new Exception;
            } else {
                //save other reason
                switch ($request->type_r) {
                    case 'contract':
                        $contract = Contract::findOrFail($request->id_r);
                        $contract->status = 'approved';
                        $contract->other_reasons = $request->other;
                        if($request->details){
                          $contract->rejection_reason  = $request->details;
                        }
                        $contract->save();

                        return trans('contracts_cancelation.refused');
                        break;

                    case 'ishaar':
                        $ishaar = ContractEmployee::findOrFail($request->id_r);
                        $ishaar->status = 'approved';
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
    }

    public function anyContractDetails($id)
    {
        $byMecontract = Contract::byMe()
            ->with([
                'vacancy' => function ($v_q) {
                    $v_q->with(["job", "region", "nationality"]);
                }
            ])
            ->with([
                'contractEmployee' => function ($v_q) {
                    $v_q->with([
                        'hrPool' => function ($hr_q) {
                            $hr_q->with(["job", "region", "nationality"]);
                        }
                    ]);
                }
            ])
            ->find($id);
        if ($byMecontract) {
            $contract = $byMecontract->load([
                'provider',
                'benef',
                "contractLocations"
            ]);
        }
        $toMecontract = Contract::toMe()
            ->with([
                'vacancy' => function ($v_q) {
                    $v_q->with(["job", "region", "nationality"]);
                }
            ])
            ->with([
                'contractEmployee' => function ($v_q) {
                    $v_q->with([
                        'hrPool' => function ($hr_q) {
                            $hr_q->with(["job", "region", "nationality"]);
                        }
                    ]);
                }
            ])
            ->find($id);
        if ($toMecontract) {
            $contract = $toMecontract->load([
                'provider',
                'benef',
                "contractLocations"
            ]);
        }
        if (!is_object($toMecontract) && !is_object($byMecontract)) {
            return abort(401);
        }

        $thisContract = $contract->toArray();

        if ($contract->contract_type_id == Constants::CONTRACTTYPES["hire_labor"]) {

            return view("front.contractdetails.hireshow", compact("thisContract"));
        }
        if ($contract->contract_type_id == Constants::CONTRACTTYPES['direct_emp']) {

            return view("front.contractdetails.directshow", compact("thisContract"));
        }

    }

    /**
     * @return mixed
     */
    public function work_completion_certificate()
    {
        if (request()->ajax()) {
            $data = Contract::byMe()->with(['vacancy', 'vacancy.job', 'vacancy.region']);
            $total_count = ($data->count()) ? $data->count() : 1;
            $columns = request()->input('columns');
            if (request()->input('id')) {
                $data = $data->whereId(request()->input('id'));
            }
            if (request()->input('job_id')) {
                $data = $data->whereHas('vacancy', function ($query) {
                    $query->where('job_id', request()->input('job_id'));
                });
            }
            if (request()->input('status')) {
                $data = $data->where('status', request()->input('status'));
            }
            if (request()->input('region_id')) {
                $data = $data->whereHas('vacancy', function ($query) {
                    $query->where('region_id', request()->input('region_id'));
                });
            }
            if (request()->input('owner_name')) {
                $data = $data->whereHas('benfEstablishment', function ($est_q) {
                    $est_q->where('name', 'LIKE', '%' . request()->input('owner_name') . '%');
                })->orWhereHas('benfGovernment', function ($gov_q) {
                    $gov_q->where('name', 'LIKE', '%' . request()->input('owner_name') . '%');
                })->orWhereHas('benfIndividual', function ($indv_q) {
                    $indv_q->where('name', 'LIKE', '%' . request()->input('owner_name') . '%');
                });
            }

            $buttons = [
                'details'              => [
                    'det'        => true,
                    "text"       => trans("labels.details"),
                    'url'        => 'javascript:;',
                    "css_class"  => "blue",
                    "attributes" => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'generate_certificate' => [
                    'gen'        => true,
                    'text'       => trans('contracts.work_completion_cert'),
                    'url'        => 'javascript:;',
                    'css_class'  => 'green',
                    'attributes' => [
                        'data-token' => csrf_token()
                    ]
                ]
            ];

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons);
        }
        $jobs = Job::lists('job_name', 'id');
        $regions = Region::lists('name', 'id');

        return view('front.work_certificate.index', compact('data', 'regions', 'jobs'));
    }


    public function followContract($ct_id, $prvd_benf)
    {
        if (!in_array($ct_id, array_values(Constants::CONTRACTTYPES)) || !in_array($prvd_benf, [1, 2])) {
            abort(404);
        }

        if (request()->ajax()) {

            $data = $prvd_benf == 1 ? Contract::byMe()->getByContractType($ct_id) : Contract::toMe()->getByContractType($ct_id);

            $total_count = ($data->count()) ? $data->count() : 1;
            $columns = request()->input('columns');
            if (request()->input('id')) {
                $data = $data->whereId(request()->input('id'));
            }
            if (request()->input('providername')) {
                $data->whereHas('establishment', function ($est_q) {
                    $est_q->where('name', 'LIKE', '%' . request()->input('providername') . '%');
                })->orWhereHas('government', function ($gov_q) {
                    $gov_q->where('name', 'LIKE', '%' . request()->input('providername') . '%');
                })->orWhereHas('individual', function ($indv_q) {
                    $indv_q->where('name', 'LIKE', '%' . request()->input('providername') . '%');
                });
            }
            if (request()->input('benf_name')) {
                $data->whereHas('benfEstablishment', function ($est_q) {
                    $est_q->where('name', 'LIKE', '%' . request()->input('benf_name') . '%');
                })->orWhereHas('benfGovernment', function ($gov_q) {
                    $gov_q->where('name', 'LIKE', '%' . request()->input('benf_name') . '%');
                })->orWhereHas('benfIndividual', function ($indv_q) {
                    $indv_q->where('name', 'LIKE', '%' . request()->input('benf_name') . '%');
                });
            }
            if (request()->input('status')) {
                $data = $data->where('status', request()->input('status'));
            }
            

            $buttons = [
                'details'                 => [
                    'det'                                           => true,
                    "text"                                          => trans("labels.details"),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/contractdetails/{id}',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/contractdetails/{id}',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/offer-taqawel-contract/{id}/details',
                    'params'                                        => ['id' => ['name' => 'id', 'value' => null]],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'send_offer'              => [
                    'text'                                          => trans('contracts.action_buttons.send_offer'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/temp_work/received-contracts/{id}/show',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/temp_work/received-contracts/{id}/show',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/received-contracts',
                    'params'                                        => ['id' => ['name' => 'id', 'value' => null]],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'reject_request'          => [
                    'text'                                          => trans('contracts.action_buttons.reject_request'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/offers/reject/{id}',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/offers/reject/{id}',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => 'taqawel/offers/reject/{id}',
                    'params'                                        => ['id' => ['name' => 'id', 'value' => null]],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'edit_offer'              => [
                    'text'                                          => trans('contracts.action_buttons.edit_offer'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/{contract_type_id}/contracts/{contracts}/edit',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/{contract_type_id}/contracts/{contracts}/edit',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/offer-taqawel-contract/{contracts}/edit',
                    'params'                                        => [
                        'contracts'        => ['name' => 'id', 'value' => null],
                        'contract_type_id' => ['name' => '', 'value' => request()->route()->parameter('ct_id')]
                    ],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'edit_request'            => [
                    'text'                                          => trans('contracts.action_buttons.edit_offer'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/{contract_type_id}/contracts/{contracts}/edit',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/{contract_type_id}/contracts/{contracts}/edit',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/offer-taqawel-contract/{contracts}/edit',
                    'params'                                        => [
                        'contracts'        => ['name' => 'id', 'value' => null],
                        'contract_type_id' => ['name' => '', 'value' => request()->route()->parameter('ct_id')]
                    ],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'cancel_offer'            => [
                    'text'                                          => trans('contracts.action_buttons.cancel_offer'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/contracts/{contracts}/cancel',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/contracts/{contracts}/cancel',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/offer-taqawel-contract/{contracts}/cancel',
                    'params'                                        => [
                        'contracts' => [
                            'name'  => 'id',
                            'value' => null
                        ]
                    ],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'generate_ishaar'         => [
                    'text'                                          => trans('contracts.action_buttons.generate_ishaar'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/{contract_type_id}/contracts/{contracts}/edit',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/{contract_type_id}/contracts/{contracts}/edit',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/notices/{contracts}',
                    'params'                                        => [
                        'contracts'        => ['name' => 'id', 'value' => null],
                        'contract_type_id' => ['name' => '', 'value' => request()->route()->parameter('ct_id')]
                    ],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'cancel_ishaar'           => [
                    'repeated'                                      => true,
                    'text'                                          => trans('contracts.action_buttons.cancel_ishaar'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/direct_ishaar/{id}/show_ishaar',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/ishaar/{id}/show_ishaar',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/notices/{id}/show_ishaar',
                    'params'                                        => ['id' => ['name' => 'id', 'value' => null]],
                    "css_class"                                     => "green",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'request_contract_cancel' => [
                    'text'                                          => trans('contracts.action_buttons.request_contract_cancel'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/contracts/{contracts}/cancel',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/contracts/{contracts}/cancel',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/offer-taqawel-contract/{contracts}/cancel',
                    'params'                                        => [
                        'contracts' => [
                            'name'  => 'id',
                            'value' => null
                        ]
                    ],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'rate_benf'               => [
                    'text'                                          => trans('contracts.action_buttons.rate_benf'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => 'javascript:;',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => 'javascript:;',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => 'javascript:;',
                    'params'                                        => ['id' => ['name' => 'id', 'value' => null]],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'process_cancel_request'  => [
                    'text'                                          => trans('contracts.action_buttons.process_cancel_request'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/contracts/cancelation/direct_hiring/{type}/{id}',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/contracts/cancelation/{type}/{id}',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/contracts/cancellation/{type}/{id}',
                    'params'                                        => [
                        'id'   => ['name' => 'id', 'value' => null],
                        'type' => ['value' => request()->route()->parameter('prvd_benf') == Constants::PRVD_BENF_SHORTCUT['1'] ? 'provider' : 'beneficial']
                    ],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'process_cancel_ishaar_request'  => [
                    'text'                                          => trans('contracts.action_buttons.process_cancel_request'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/contracts/cancelation/ishaar/direct_hiring/{type}/{id}',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/contracts/cancelation/ishaar/{type}/{id}',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/notices/{id}/show_ishaar',
                    'params'                                        => [
                        'id'   => ['name' => 'id', 'value' => null],
                        'type' => ['value' => request()->route()->parameter('prvd_benf') == Constants::PRVD_BENF_SHORTCUT['1'] ? 'provider' : 'beneficial']
                    ],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'revert_cancel'           => [
                    'text'                                          => trans('contracts.action_buttons.revert_cancel'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/offersdirect/accept/approve/{id}',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/offers/accept/approve/{id}',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/offers/accept/approve/{id}',
                    'params'                                        => ['id' => ['name' => 'id', 'value' => null]],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'print_ishaar'            => [
                    'repeated'                                      => true,
                    'text'                                          => trans('contracts.action_buttons.print_ishaar'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/direct_ishaar/{id}/show_ishaar/?print=1',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/ishaar/{id}/show_ishaar/?print=1',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/notices/{id}/show_ishaar/?print=1',
                    'params'                                        => ['id' => ['name' => 'id', 'value' => null]],
                    "css_class"                                     => "green",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'rate_provider'           => [
                    'text'                                          => trans('contracts.action_buttons.rate_provider'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => 'javascript:;',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => 'javascript:;',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => 'javascript:;',
                    'params'                                        => ['id' => ['name' => 'id', 'value' => null]],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
                'view_offer'              => [
                    'text'                                          => trans('contracts.action_buttons.view_offer'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/offers/{id}',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/offers/{id}',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel//offers/{id}',
                    'params'                                        => ['id' => ['name' => 'id', 'value' => null]],
                    "css_class"                                     => "blue",
                    "attributes"                                    => [
                        "data-token" => csrf_token(),
                    ],
                ],
            ];

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons, false, [], ['follow_contracts']);
        }

        return view('front.follow_contracts.index', compact('data', 'prvd_benf', 'ct_id'));
    }

     /**
     * generate a newly invoice in storage.
     *
     * @return Response
     */
    public function generateCertificateInvoice( ContractCertificateRequest $request, Connector $connector)
    {
       
        $contracts_id = $request->contract_ids;
        // Check if the user can make new invoice or not
        $open_invoices = ContractCertificate::whereIn('contract_id',$contracts_id)->whereHas('invoice', function($query){
                $query->pending()->notExpired();
        })->count();
        
        if ($open_invoices) {
            return response()->json(['error' => trans('contract_setup.cant_add_invoice')], 422);
        }
        $contract_setup = ContractSetup::where('contract_type_id',Constants::CONTRACTTYPES['direct_emp'])->first();
        $amount = $contract_setup->experience_certificate_amount * count($contracts_id);
        $days = 3;
        $issueDate = Carbon::now()->toDateTimeString();
        $expiryDate = Carbon::now()->addDays($days);
        $accountNumber = getLoggedAccountNumber($connector);
        $provider_id  = getCurrentUserNameAndId()[0];
         $items         = [
            [
                'item_name'  => trans('contract_setup.generate_description',['number' => count($contracts_id)]),
                'item_count' => count($contracts_id),
                'item_price' => $amount,
            ],
        ];
        $createdBill   = $connector->createBill($accountNumber, $amount, $items, $expiryDate);
        //End Making Invoice

        //create Invoice
        $invoice                = new Invoice;
        $invoice->bill_number   = $createdBill['bill_number'];
        $invoice->amount = $amount;
        $invoice->account_no = $accountNumber;
        $invoice->benf_name = "";
        $invoice->issue_date = $issueDate;
        $invoice->expiry_date = $expiryDate;
        $invoice->description = trans('contract_setup.generate_description',['number' => count($contracts_id)]);
        $invoice->status = Constants::INVOICE_STATUS['pending'];
        $invoice->provider_type = Auth::user()->user_type_id;
        $invoice->provider_id   = $provider_id;
        $invoice->invoice_type  = Constants::INVOICE_TYPES['certificate'];
        $invoice->save();

        // track all contracts & invoices
        foreach($contracts_id as $contract_id){
        $certificate = new ContractCertificate;
        $certificate->contract_id = $contract_id;
        $certificate->invoice_id = $invoice->id;
        $certificate->save();
        }
        return response()->json(trans('contract_setup.add_invoice_success',['number' => $invoice->bill_number,'amount' => $amount]));
        
    }
}
