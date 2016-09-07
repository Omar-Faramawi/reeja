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
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\User;
use Tamkeen\Ajeer\Utilities\Constants;

/**
 * Class ContractsController
 * @package Tamkeen\Ajeer\Http\Controllers\Front
 */
class ContractsController extends Controller
{

    /**
     *
     * Show the contracts here
     */
    public function index($contractTypeId = 3)
    {
        if (request()->ajax()) {
            $query = Contract::byMe()->getByContractType($contractTypeId);

            $total_count = $query->count();
            $columns = request()->input('columns');


            $buttons = [
                'edit'    => [
                    "text"      => trans("labels.edit"),
                    "url"       => url($contractTypeId . "/contracts"),
                    "col"       => "id",
                    "uri"       => "edit",
                    "css_class" => "blue",
                ],
                'cancel'  => [
                    "text"      => trans("labels.cancel"),
                    "url"       => url("/contracts"),
                    "col"       => "id",
                    "uri"       => "cancel",
                    "css_class" => "red",
                ],
                'details' => [
                    "text"      => trans("labels.details"),
                    "url"       => url("/contracts"),
                    "col"       => "id",
                    "uri"       => "details",
                    "css_class" => "white",
                ],

            ];

            return dynamicAjaxPaginate($query, $columns, $total_count, $buttons);
        }

        return view('front.contracts.index', compact('contractTypeId'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View Edit the resource
     *
     * Edit the resource
     */
    public function edit($contractTypeId = 3, $id)
    {
        $contract = Contract::byMe()->getByContractType($contractTypeId)
            ->with('vacancy.job', 'vacancy.nationality', 'contractLocations')
            ->findOrFail($id);

        $jobs = Job::pluck('job_name', 'id')->toArray();
        $nationalities = Nationality::pluck('name', 'id')->toArray();
        $providers = User::pluck('name', 'id')->toArray();
        $regions = Region::pluck('name', 'id')->toArray();

        return view('front.contracts.edit', compact('contract', 'jobs', 'nationalities', 'providers', 'regions'));
    }

    /**
     * @param ReceivedContractRequest $request
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function update(ReceivedContractRequest $request, $id)
    {

        $vacancyData = $request->only(['start_date', 'end_date']);
        $contractData = $request->only(['job_id', 'nationality_id', 'gender', 'job_type']);

        try {
            $contract = Contract::byMe()->findOrFail($id);

            if (isset($request->region_id)) {
                foreach ($request->region_id as $region) {
                    $contract->contractLocations()->updateOrCreate([
                        'branch_id' => session()->get('selected_establishment.id'),
                        'region_id' => $region,
                    ]);
                }
            }

            $contract->update($vacancyData);
            $contract->vacancy()->update($contractData);

        } catch (ModelNotFoundException $exception) {
            abort(404);
        }

        return trans('contracts.updated');
    }


    public function benfCancel($id)
    {
        list($userId, $username) = getCurrentUserNameAndId();

        try {
            $contract = Contract::byMe()->with('vacancy.job', 'vacancy.nationality')->findOrFail($id);
            $reasons = Reason::pluck('reason', 'id')->reverse()->toArray();

            if ($contract->status == "pending" || $contract->status == "approved") {
                $canCancel = true;
            } else {
                $canCancel = false;
            }

            $benfName = Contract::getName($contract->benf_type, $contract->benf_id);

        } catch (ModelNotFoundException $e) {
            abort(404);
        }


        return view('front.contracts.details',
            compact('userId', 'username', 'contract', 'benfName', 'canCancel', 'reasons'));

    }


    public function updateStatus(ContractsRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));
        try {
            Contract::findOrFail($request->id)->update($data);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return trans('contracts.updated');
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

        return view('front.contracts.cancelation.hire_labor.ishaar.index');
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

        return view('Front.contracts.cancelation.hire_labor.contract.show', compact('contract', 'reasons'));
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

        return view('Front.contracts.cancelation.hire_labor.ishaar.show', compact('contractEmployee', 'reasons'));

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

        return view('Front.contracts.cancelation.direct_hiring.contract.index');
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

        return view('Front.contracts.cancelation.direct_hiring.ishaar.index');
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

        return view('Front.contracts.cancelation.direct_hiring.contract.show', compact('contract', 'reasons'));
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

        return view('Front.contracts.cancelation.direct_hiring.ishaar.show', compact('contractEmployee', 'reasons'));
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


    public function taqawelOfferContract()
    {
        if (request()->ajax()) {


            if (request()->route()->getName() === "occasional-labor-market.index") {
                $query = $query->onlyMuslims();
            }

            $total_count = $query->count();
            $columns = request()->input('columns');

            $inputs = request()->only([
                'id',
                "gender",
                "nationality_id",
                "work_start_date",
                "work_end_date",
            ]);

            foreach ($inputs as $key => $input) {
                if (request()->input($key)) {
                    $query = $query->where($key, $input);
                }
            }

            if ($job_name = request()->input('job_name')) {
                $query = $query->whereHas('job', function ($q) use ($job_name) {
                    return $q->where('job_name', 'LIKE', '%' . $job_name . '%');
                });
            }


            if (session()->get('service_type') === Constants::SERVICETYPES['provider']) {

                $buttons = [
                    'show' => [
                        "text"      => trans("temp_job.show_offer"),
                        "url"       => url(request()->segment(1) . "/received-contracts"),
                        "col"       => "id",
                        "uri"       => "show",
                        "css_class" => "blue",
                    ],
                ];

            } else {

                $buttons = [
                    'show' => [
                        "text"      => trans("temp_job.ask_offer"),
                        "url"       => null,
                        "col"       => null,
                        "uri"       => null,
                        "css_class" => "ask-offer-benf blue",
                    ],
                ];
            }

            return dynamicAjaxPaginate($query, $columns, $total_count, $buttons);


        }
        // current logged in to this page is provider type
        session()->replace(['service_type' => Constants::SERVICETYPES['provider']]);

        $currentRouteName = request()->route()->getName();
        $regions = Region::all()->pluck('name', 'id')->toArray();
        $jobs = Job::all()->pluck('job_name', 'id')->toArray();
        $nationalities = Nationality::all()->pluck('name', 'id')->toArray();

        return view('front.labor_market.tqawel.index', compact('regions', 'jobs', 'nationalities', 'currentRouteName'));
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
                'cancel_ishaar'           => [
                    'repeated'                                      => true,
                    'text'                                          => trans('contracts.action_buttons.cancel_ishaar'),
                    'uri_' . Constants::CONTRACTTYPES['direct_emp'] => '/direct_ishaar/{id}/cancel_ishaar',
                    'uri_' . Constants::CONTRACTTYPES['hire_labor'] => '/ishaar/{id}/cancel_ishaar',
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/notices/{id}/cancel_ishaar',
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
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/offer-taqawel-contract/{id}/cancel',
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
                    'uri_' . Constants::CONTRACTTYPES['taqawel']    => '/taqawel/notices/{id}/cancel_ishaar',
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
}
