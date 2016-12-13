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
use Tamkeen\Ajeer\Models\BaseModel;
use Illuminate\Support\Facades\Auth;
use Tamkeen\Ajeer\Repositories\MOL\MolDataRepository;
use Tamkeen\Ajeer\Models\SaudiPercentage;
use Tamkeen\Ajeer\Models\Establishment;
use Illuminate\Support\Facades\DB;

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
        if (count($paid_package)) {
            $ishaar_setup = IshaarSetup::taqawelPaid()->first();
            $can_cancel= $ishaar_setup->ishaar_cancel_paid;
        } else {
            $ishaar_setup = IshaarSetup::taqawelFree()->first();
            if ($ishaar_setup) 
            {
                $can_cancel = $ishaar_setup->ishaar_cancel_free;
            } else {
                $can_cancel = 0;
            }
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

            if ($job_id = request()->input('job_id')) {
                $ishaars = $ishaars->whereHas('hrPool', function ($q) use ($job_id) {
                    $q->where('job_id', $job_id);
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

            if ($job_id = request()->input('job_id')) {
                $ishaars = $ishaars->whereHas('hrPool', function ($q) use ($job_id) {
                    $q->where('job_id', $job_id);
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
            if (Auth::user()->user_type_id == Constants::USERTYPES['est']) {
                $canBeProvider = BaseModel::estCanBeProvider();
            }  elseif (Auth::user()->user_type_id == Constants::USERTYPES['saudi']) {
                $canBeProvider = BaseModel::indvCanBeProvider();
            }
        }
        $jobs = Job::all()->pluck('job_name', 'id')->toArray();

        return view('front.taqawel.notices.index', compact('contracts','canBeProvider','jobs'));
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
    public function store(TaqawelNoticesRequest $request,MolDataRepository $mol)
    {
        $contract_id   = request()->input('contract_id');
        $emp_ids       = request()->input('ids');
        $work_areas    = request()->input('work_areas');
        $start_date    = request()->input('start_date');
        $end_date      = request()->input('end_date');
        $contract      = Contract::byMe()->approved()->taqawel()->findOrFail($contract_id);
        $benf_id       = $contract->benf_id;
        $benf_type     = $contract->benf_type;
        $provider_id   = $contract->provider_id;
        $provider_type = $contract->provider_type;

        // check if current Establishment or It's Benef Est Exceed percentage of loan Or Borrow
        $curr_est = session()->get('selected_establishment');
        if ($curr_est) {
            //check if current user provider exceed the saudian percentage or not
        $contract_ishaars = $contract->contractEmployee;
        if ($contract_ishaars) {
                $contract_emps = count($contract->hrPool) + count($emp_ids);
                if($contract->benf_type == Constants::USERTYPES['est']) {
                    $benf_size = Establishment::find($benf_id)->est_size;
                    $pcr = SaudiPercentage::taqawel()->where('provider_activity_id',
                                request()->input('provider_activity'))
                            ->where('benf_activity_id',
                                request()->input('benf_activity'))
                            ->where('provider_size_id', $benf_size)
                            ->where('benf_size_id', request()->input('provider_activity'))->first(['saudi_pct']);
                    if($pcr){
                    if (filter_var(($contract_emps / $pcr->saudi_pct),FILTER_VALIDATE_INT)) {
                        $allowed_pct = ($pcr->saudi_pct / 100) * $contract_emps;
                        if ($contract_emps > $allowed_pct) {
                            return response()->json(['error' => trans('ishaar_setup.max_saudian_percentage')],
                                    422);
                        }
                    }
                    }
                }
            }
            //Provider Loan percentage
            $est_emp_count = $mol->fetchEstablishmentLaborersCount($curr_est->FK_establishment_id);
            $loan_pct = BaseModel::estLoanPercentage(request()->input('provider_activity'));
            if ($loan_pct >0) {
                $Lpercentage = ($loan_pct / 100) * $est_emp_count;
                $emps = ContractEmployee::MaxIshaarsForProvider($provider_id, $provider_type) + count($emp_ids);
                if( $emps > $Lpercentage){
                    return response()->json(['error' => trans('ishaar_setup.max_loan_percentage')], 422);
                }
            }
            //benf borrow percentage
            $est_emp_count = $mol->fetchEstablishmentLaborersCount(request()->input('benf_FK'));
            $borrow_pct = BaseModel::estBorrowPercentage(request()->input('benf_activity'));
            if ($borrow_pct >0) {
                $Bpercentage = ($borrow_pct / 100) * $est_emp_count;
                $emps = ContractEmployee::MaxIshaarsForBenf($benf_id, $benf_type) + count($emp_ids);
                if ($emps > $Bpercentage) {
                   return response()->json(['error' => trans('ishaar_setup.max_borrow_percentage')], 422);
                }
            }
        }
        //check if Notice Dates between contract period
        $start_in_period = checkInRange(request()->input('contract_start_date'), request()->input('contract_end_date'),
            $start_date);
        $end_in_period   = checkInRange(request()->input('contract_start_date'), request()->input('contract_end_date'),
            $end_date);
        if ($start_in_period && $end_in_period) {
            $account_type = InvoiceBundle::byMe()->paid()->notExpired()->hasRemainingNotices()->get();
            if (count($account_type)) {
                $ishaar_setup     = IshaarSetup::taqawelPaid()->first();
                $num_of_months    = getDiffPeriodMonth($start_date, $end_date);
                $wanted           = count($emp_ids) * $num_of_months;
                $allowence_number = InvoiceBundle::byMe()->paid()->notExpired()->hasRemainingNotices()->allowedNotices();
                if ($allowence_number < $wanted) {
                    return response()->json(['error' => trans('ishaar_setup.employees_bigger_allowed')], 422);
                }
                //check max ishaar period
                $max_date = getDiffPeriodDay($start_date, $ishaar_setup->max_ishaar_period, $ishaar_setup->max_ishaar_period_type);
                $in_range = checkInRange($start_date, $max_date, $end_date);
                if(!$in_range){
                    return response()->json(['error' => trans('ishaar_setup.max_ishaar_period_exceeded')], 422);
                }
                //check max ishaars for this benf
                if(ContractEmployee::MaxIshaarsForBenf($benf_id, $benf_type) >= $ishaar_setup->labor_same_benef_max_num_of_ishaar){
                    return response()->json(['error' => trans('ishaar_setup.max_ishaar_for_benf')], 422);
                }
            }else{
                $ishaar_setup = IshaarSetup::taqawelFree()->first();
                //check max ishaars num per month
                $current_month_ishaars_num = ContractEmployee::whereHas('contract',
                    function ($cont_q) {
                        $cont_q->byMe()->approved()->taqawel();
                    })->where(DB::raw('MONTH(created_at)'), '=', date('n'))->count();
                
                if($current_month_ishaars_num >= $ishaar_setup->max_no_of_ishaars)
                    return response()->json(['error' => trans('ishaar_setup.max_ishaar_per_month')], 422);
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
                    $min_date = ContractEmployee::MinEmployeeIshaarsForBenfInPeriod($benf_id, $benf_type, $emp);
                    $max_date = ContractEmployee::MaxEmployeeIshaarsForBenfInPeriod($benf_id, $benf_type, $emp);
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
            }
            foreach ($emp_ids as $emp) {

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

               
            }
             return trans('ishaar_setup.add_notice_success');
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
    public function show($id, MolDataRepository $mol)
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
            $columns = request()->input('columns');
            
            $filters = array('AllowedEmployeesType' => '1', 'AllowedEmployeesGender' => '1', 'buttons' => '1');
           
            if (request()->id_number) {
                $filters['id_number'] = request()->id_number;
            }
            if (request()->nationality_id) {
                $filters['nationality'] = request()->nationality_id;
            }
            if (request()->input('job_id')) {
                $filters['job'] = request()->job_id;
            }
            $employees = $mol->fetchEstablishmentLaborers(session('selected_establishment')->FK_establishment_id, $filters,$ishaar_setup);
            $total_count = $employees->count() ? $employees->count() : 1;
            $buttons = [];

            return dynamicAjaxPaginate($employees, $columns, $total_count, $buttons);
        }
        
        $jobs          = $mol->fetchJobsLookup();
        $nationalities = $mol->fetchNationalitiesLookup();
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

