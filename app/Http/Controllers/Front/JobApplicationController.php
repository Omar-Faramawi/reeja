<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\Vacancy;
use Tamkeen\Ajeer\Utilities\Constants;

class JobApplicationController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Vacancy::active()->with(['region', 'job']);
            $total_count = ($data->count()) ? $data->count() : 1;
            $columns = request()->input('columns');
            if (request()->input('job_id')) {
                $data = $data->where('job_id', request()->input('job_id'));
            }
            if (request()->input('region_id')) {
                $data = $data->where('region_id', request()->input('region_id'));
            }
            if (request()->input('work_start_date')) {
                $data = $data->where('work_start_date', '>=', request()->input('work_start_date'));
            }
            if (request()->input('work_end_date')) {
                $data = $data->where('work_end_date', '<=', request()->input('work_end_date'));
            }
            if (request()->input('job_type') != null) {
                $data = $data->where('job_type', request()->input('job_type'));
            }
            if (request()->input('owner_name')) {
                $data = $data->whereHas('establishment', function ($est_q) {
                    $est_q->where('name', 'LIKE', '%' . request()->input('owner_name') . '%');
                })->orWhereHas('government', function ($gov_q) {
                    $gov_q->where('name', 'LIKE', '%' . request()->input('owner_name') . '%');
                })->orWhereHas('individual', function ($indv_q) {
                    $indv_q->where('name', 'LIKE', '%' . request()->input('owner_name') . '%');
                });
            }

            $buttons = [
                'apply' => [
                    "text"       => trans("labor_market.apply"),
                    "url"        => url("/job_search"),
                    "uri"        => "apply_to_job",
                    "css_class"  => "blue apply_vacancy",
                    "attributes" => [
                        "data-token" => csrf_token(),
                    ],
                ],
            ];

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons);
        }

        $data = HRPool::me()->first();

        // Extracts the first character from the National ID
        $nidChar = substr(auth()->user()->national_id, 0, 1);

        // Regions depending on whether the user is not Muslim or not saudi and visitor
        if ($data->religion != 1) {
            $regions = Region::where('id', '!=', 1)->lists('name', 'id');
        } elseif (!in_array($nidChar, [1, 2])) {
            $regions = Region::whereId(1)->lists('name', 'id');
        } else {
            $regions = Region::lists('name', 'id');
        }

        $jobs = Job::lists('job_name', 'id');

        return view('front.job_application.index', compact('data', 'regions', 'jobs'));
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function apply($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        
        // HRPool record
        $employee_data = HRPool::me()->first();

        $can_apply = $employee_data->chk == 1 ? true : false;
        if(!$can_apply)
            return response()->json(['error' => trans('labor_market.complete_your_cv')], 422);

        if(!in_array($vacancy->job_id, Job::allowed(['id'], $employee_data->nationality_id)->toArray()))
            return response()->json(['error' => trans('labor_market.not_allowed_job')], 422);

        $already_applied = Contract::byMe()->directEmp()->where('vacancy_id', $id)->count();
        if ($already_applied) {
            return response()->json(['error' => trans('labor_market.already_applied')], 422);
        }

        $active_contracts = Contract::byMe()->directEmp()->approved()
            ->where(function($active_contracts) use ($vacancy) {
                return $active_contracts->whereBetween('start_date', [$vacancy->work_start_date, $vacancy->work_end_date])->
                orWhereBetween('end_date', [$vacancy->work_start_date, $vacancy->work_end_date]);
            })
            ->count();
        if ($active_contracts) {
            return response()->json(['error' => trans('labor_market.start_end_conflict')], 422);
        }

        $contract = [
            'contract_type_id' => Constants::CONTRACTTYPES['direct_emp'],
            'benf_id'          => $vacancy->benf_id,
            'benf_type'        => $vacancy->benf_type,
            'provider_type'    => auth()->user()->user_type_id,
            'provider_id'      => auth()->user()->id_no,
            'status'           => 'requested',
            'start_date'       => $vacancy->work_start_date,
            'end_date'         => $vacancy->work_end_date,
            'vacancy_id'       => $id,
            'contract_amount'  => $vacancy->salary,
            'job_type'         => $vacancy->job_type
        ];

        if ($contract_record = Contract::create($contract)) {
            $contract_record->employees()->create([
                'id_number'  => $employee_data->id,
                'start_date' => $contract_record->start_date,
                'end_date'   => $contract_record->end_date,
                'salary'     => $vacancy->salary,
                'status'     => 'pending',
                'ishaar_id'  => Constants::CONTRACTTYPES['direct_emp'],
            ]);

            return trans('labor_market.applied');
        }

        return response()->json(['error' => trans('labor_market.error_applying')], 422);
    }
}
