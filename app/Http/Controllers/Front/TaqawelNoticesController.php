<?php

namespace Tamkeen\Ajeer\Http\Controllers\front;

use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\ContractEmployeeLocation;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\IshaarSetup;
use Tamkeen\Ajeer\Models\InvoiceBundle;
use Tamkeen\Ajeer\Models\Reason;
use Tamkeen\Ajeer\Http\Requests\TaqawelNoticesRequest;
use Tamkeen\Ajeer\Http\Requests\CancelIshaarRequest;
use Tamkeen\Ajeer\Utilities\Constants;

class TaqawelNoticesController extends Controller
{
    
    /**
     * Show Ishaar Layout.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        $isProvider = TRUE;
        // Get the current service type id ( provider or benf )
        // check if we got the right one before continue
        if ($id) {
            if (in_array($id, Constants::SERVICETYPES)) {
                session()->replace(['service_type' => $id]);    // save to session
            }
        }

        if (session()->get('service_type') === Constants::SERVICETYPES['benf']) {
            $isProvider = FALSE;
        }
        $paid_package = InvoiceBundle::byMe()->paid()->notExpired()->get();
        if(count($paid_package)){
            $ishaar_setup = IshaarSetup::taqawelPaid()->first();
            $can_cancel= $ishaar_setup->ishaar_cancel_paid;
        }else{
            $ishaar_setup = IshaarSetup::taqawelFree()->first();
            $can_cancel= $ishaar_setup->ishaar_cancel_free;
        }

        if (request()->ajax()) {
            $columns = request()->input('columns');
            
            if ($isProvider) {
                $ishaars = ContractEmployee::whereHas('contract',
                    function ($cont_q) {
                        $cont_q->byMe()->approved()->taqawel();
                    })->with(['hrPool.job', 'contract.contractLocations']);
            } else {
                $ishaars = ContractEmployee::whereHas('contract',
                    function ($cont_q) {
                        $cont_q->toMe()->approved()->taqawel();
                    })->with(['hrPool.job', 'contract.contractLocations']);
            }

            if (request()->input('benf_name')) {
                $ishaars = $ishaars->whereHas('contract', function ($provider_q) {
                    $provider_q->whereHas('benfEstablishment', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('benf_name') . '%');
                    });
                    $provider_q->orWhereHas('benfIndividual', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('benf_name') . '%');
                    });
                    $provider_q->orWhereHas('benfGovernment', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('benf_name') . '%');
                    });
                });
            }
            
            if ($job = request()->input('job')) {
                $ishaars = $ishaars->whereHas('hrPool', function ($q) use ($job) {
                    $q->whereHas('job', function ($q) use ($job) {
                        return $q->where('job_name', 'LIKE', '%' . $job . '%');
                    });
                });
            }
            if ($id_number = request()->input('id_number')) {
                $ishaars = $ishaars->whereHas('hrPool', function ($q) use ($id_number) {
                    $q->where('id_number', $id_number);
                });
            }
            if ($name = request()->input('name')) {
                $ishaars = $ishaars->whereHas('hrPool', function ($q) use ($name) {
                    $q->where('name', 'LIKE', '%' . $name . '%');
                });
            }
            if (request()->input('start_date')) {
                $ishaars = $ishaars->where('start_date', request()->input('start_date'));
            }
            if (request()->input('end_date')) {
                $ishaars = $ishaars->where('end_date', request()->input('end_date'));
            }
            if (request()->input('status')) {
                $ishaars = $ishaars->where('status', request()->input('status'));
            }
            
            $total_count = $ishaars->count() ? $ishaars->count() : 1;
            if($can_cancel){
            $buttons = [
                'view'  => [
                    "text"      => trans("ishaar_setup.actions.cancel"),
                    "url"       => url('taqawel/notices'),
                    "uri"       => "show_ishaar",
                    "css_class" => "red askcancelishaar",
                ],
                'print' => [
                    "text"      => trans("ishaar_setup.actions.print"),
                    "url"       => url('taqawel/notices'),
                    "uri"       => "show_ishaar?print=1",
                    "css_class" => "blue",
                ],
            ];
            }else{
                $buttons = [
                'print' => [
                    "text"      => trans("ishaar_setup.actions.print"),
                    "url"       => url('taqawel/notices'),
                    "uri"       => "show_ishaar?print=1",
                    "css_class" => "blue",
                ],
            ];
            }
            
            return dynamicAjaxPaginate($ishaars, $columns, $total_count,
                $buttons);
        }

        $contracts = [];
        if ($isProvider) {
            $contracts = Contract::byMe()->approved()->taqawel()->get();
        }
        
        return view('front.taqawel.notices.index', compact('contracts'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('front.taqawel.notices.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(TaqawelNoticesRequest $request)
    {
        $contract_id = request()->input('contract_id');
        $emp_ids     = request()->input('ids');
        $work_areas  = request()->input('work_areas');
        $start_date  = request()->input('start_date');
        $end_date    = request()->input('end_date');
        $contract    = Contract::byMe()->approved()->taqawel()->findOrFail($contract_id);
        $benf_id     = $contract->benf_id;

        //check if Notice Dates between contract period
        $start_in_period = checkInRange(request()->input('contract_start_date'), request()->input('contract_end_date'),
            $start_date);
        $end_in_period   = checkInRange(request()->input('contract_start_date'), request()->input('contract_end_date'),
            $end_date);
        if ($start_in_period && $end_in_period) {
            $account_type = InvoiceBundle::byMe()->paid()->notExpired()->hasRemainingNotices()->get();
            if (count($account_type)) {
                $num_of_months    = getDiffPeriodMonth($start_date, $end_date);
                $wanted           = count($emp_ids) * $num_of_months;
                $allowence_number = InvoiceBundle::byMe()->paid()->notExpired()->hasRemainingNotices()->allowedNotices();
                if ($allowence_number < $wanted) {
                    return response()->json(['error' => trans('ishaar_setup.employees_bigger_allowed')], 422);
                }
                $ishaar_setup = IshaarSetup::taqawelPaid()->first();
                //check max ishaars for this benf
                if(ContractEmployee::MaxIshaarsForBenf($benf_id) >= $ishaar_setup->labor_same_benef_max_num_of_ishaar){
                    return response()->json(['error' => trans('ishaar_setup.max_ishaar_for_benf')], 422);
                }
            }else{
                $ishaar_setup = IshaarSetup::taqawelFree()->first();
            }
            foreach ($emp_ids as $emp) {
                //check max labor times for Establishment
                if(HRPool::MaxLaborTimes($emp) >= $ishaar_setup->ishaar_lobor_times){
                    return response()->json(['error' => trans('ishaar_setup.max_labor_times',['id' => $emp])], 422);
                }
                //check max total period labor for employee
                if(HRPool::MaxTotalPeriodTimes($emp, $start_date, $end_date) >= $ishaar_setup->total_period_labor){
                    return response()->json(['error' => trans('ishaar_setup.max_total_period_labor',['id' => $emp])], 422);
                }
                if (count($account_type)) {
                    $max = $ishaar_setup->calcMaxPeriodInMonths($ishaar_setup->labor_same_benef_max_period_of_ishaar,
                        $ishaar_setup->labor_same_benef_max_period_of_ishaar_type);
                    $min_date = ContractEmployee::MinEmployeeIshaarsForBenfInPeriod($benf_id,
                            $emp);
                    $max_date = ContractEmployee::MaxEmployeeIshaarsForBenfInPeriod($benf_id,
                            $emp);
                    $diff_dates = $ishaar_setup->calcTwoDatesDiffInMonths($min_date,
                        $max_date);
                    if ($max && $min_date && $max_date) {
                        //check max total period labor for employee
                        if ($diff_dates >= $max) {
                            return response()->json(['error' => trans('ishaar_setup.max_total_period_labor',
                                        ['id' => $emp])], 422);
                        }
                    }
                }

                $add              = new ContractEmployee();
                $add->contract_id = $contract_id;
                $add->id_number   = $emp;
                $add->start_date  = request()->input('start_date');
                $add->end_date    = request()->input('end_date');
                $add->status      = Constants::CONTRACT_STATUSES['approved'];
                $add->ishaar_id   = Constants::CONTRACTTYPES['taqawel'];
                if (count($account_type)) {
                    $bundle_id      = InvoiceBundle::bundelsDeduction($num_of_months);
                    $add->bundle_id = $bundle_id;
                }
                $add->save();
                foreach ($work_areas as $area) {
                    $add_area              = new ContractEmployeeLocation();
                    $add_area->employee_id = $add->id;
                    $add_area->location    = $area;
                    $add_area->chk         = 1;
                    $add_area->save();
                }

                return trans('ishaar_setup.add_notice_success');
            }
        } else {

            return response()->json(['error' => trans('ishaar_setup.date_not_in_range')], 422);
        }

    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $accountType   = InvoiceBundle::byMe()->paid()->notExpired()->hasRemainingNotices()->get();
        if (count($accountType)) {
            $ishaar_setup = IshaarSetup::taqawelPaid()->first();
            $type = Constants::CONTRACTTYPES['taqawel_paid'];
        } else {
            $ishaar_setup = IshaarSetup::taqawelFree()->first();
            $type = Constants::CONTRACTTYPES['taqawel_free'];
        }
        if (!$ishaar_setup) {
            return abort(404);
        }
        if (request()->ajax()) {
            $columns     = request()->input('columns');
            $employees   = HRPool::byMe()->allowedEmployeesType($type)->allowedEmployeesGender($type)->with('job', 'nationality', 'region');
            $total_count = $employees->count() ? $employees->count() : 1;
            
            if (request()->input('id_number')) {
                $employees = $employees->where('id_number', request()->input('id_number'));
            }
            if (request()->input('nationality_id')) {
                $employees = $employees->where('nationality_id', request()->input('nationality_id'));
            }
            if (request()->input('job_id')) {
                $employees = $employees->where('job_id', request()->input('job_id'));
            }
            
            $buttons = [
                'add' => [
                    "text"      => trans("ishaar_setup.actions.add_emp"),
                    "url"       => null,
                    "uri"       => null,
                    "css_class" => "blue add_contract_employee",
                ],
            ];

            return dynamicAjaxPaginate($employees, $columns, $total_count, $buttons, true);
        }
        $jobs          = Job::all()->pluck('job_name', 'id')->toArray();
        $nationalities = Nationality::all()->pluck('name', 'id')->toArray();
        $contract      = Contract::byMe()->findOrFail($id);
        $maxdays = $ishaar_setup->calcMaxPeriodInDays($ishaar_setup->max_ishaar_period,
            $ishaar_setup->max_ishaar_period_type);
        
        return view('front.taqawel.notices.create',
            compact('contract', 'jobs', 'nationalities', 'accountType', 'maxdays'));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function showIshaar($id)
    {
        if (session()->get('service_type') === Constants::SERVICETYPES['benf']) {
            $contract = ContractEmployee::whereHas('contract', function ($cont_q) {
                $cont_q->toMe()->approved()->taqawel();
            })->findOrFail($id);
        } else{
            $contract = ContractEmployee::whereHas('contract', function ($cont_q) {
                $cont_q->byMe()->approved()->taqawel();
            })->findOrFail($id);
        }
        $reasons  = Reason::where('parent_id', 5)->get();
        
        return view('front.taqawel.notices.show', compact('contract', 'reasons'));
    }
        
    /**
     * change the status of specified resource from storage.
     *
     * @param CancelIshaarRequest $request
     *
     * @return Response
     * @throws Exception
     */
    public function askCancelIshaar(CancelIshaarRequest $request)
    {
        $auth   = ContractEmployee::has_permission_cancelIshaar($request->id_r);
        $ishaar = ContractEmployee::findOrFail($request->id_r);
        if (!in_array($ishaar->status, ['cancelled', 'provider_cancel', 'benef_cancel'])) {
            if ($auth == '1') {
                if (session()->get('service_type') === Constants::SERVICETYPES['provider']) {
                    $status = 'provider_cancel';
                } else {
                    $status = 'benef_cancel';
                }
                
                $msg = trans('ishaar_setup.ask_cancel_ishaar_success');
                
            } else {
                $status = 'cancelled';
                $msg    = trans('ishaar_setup.cancelIshaar_success');
            }
            if ($request->reason != 'other') {
                $ishaar->status           = $status;
                $ishaar->reasons_id       = $request->reason;
                $ishaar->rejection_reason = $request->details;
                $ishaar->save();
                
                return $msg;
            } else {
                if (!$request->other) {
                    throw new Exception;
                } else {
                    $ishaar->status           = $status;
                    $ishaar->rejection_reason = $request->details;
                    $ishaar->other_reasons    = $request->other;
                    $ishaar->save();
                    
                    return $msg;
                }
            }
        } else {
            return response()->json(['error' => trans('ishaar_setup.cancelIshaar_refused')],
                422);
        }
        
        return response()->json(['error' => trans('labels.not_authorized')], 422);
    }
}
