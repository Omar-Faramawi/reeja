<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Carbon\Carbon;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\Vacancy;
use Tamkeen\Ajeer\Utilities\Constants;


/**
 * Class LaborMarketController
 * @package Tamkeen\Ajeer\Http\Controllers\Front
 */
class LaborMarketController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
		$occasionalWork = FALSE;
		if (request()->route()->getName() === "occasional-labor-market.index") {
			$occasionalWork = TRUE;
		}
		
        if (request()->ajax()) {

            // if the user is provider
            if (session()->get('service_type') === Constants::SERVICETYPES['provider']) {
                $query = Vacancy::byOthers()->with('job', 'nationality','region');
            } else {
                // if the user is beneficial
                $query = HRPool::byOthers()->with('job', 'nationality','region')->checked();
            }

            if (request()->route()->getName() === "occasional-labor-market.index") {
                $query->seasonal()->onlyMuslims();
            } else {
                $query->notSeasonal();
            }

            $total_count = ($query->count()) ? $query->count() : 1;
            $columns     = request()->input('columns');


            $inputs = request()->only([
                'id',
                "gender",
                "nationality_id",
                "work_start_date",
                "work_end_date",
            ]);

            foreach ($inputs as $key => $input) {
                if (request()->input($key) || request()->input($key) === '0') {
                    $query->where($key, $input);
                }
            }

            if ($job_name = request()->input('job_name')) {
                $query->whereHas('job', function ($q) use ($job_name) {
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
                        "url"       => '#',
                        "css_class" => "select_emp blue",
                    ],
                ];
            }

            return dynamicAjaxPaginate($query, $columns, $total_count, $buttons,true);


        }

        // Get the current service type id ( provider or benf )
        // check if we got the right one before continue
        if ($id) {
            if (in_array($id, Constants::SERVICETYPES)) {
                session()->replace(['service_type' => $id]);    // save to session
            }
        } elseif (session()->get('service_type')) {
            $id = session()->get('service_type');
        } else {
            $id = Constants::SERVICETYPES['provider'];
            session()->replace(['service_type' => $id]);
        }

        $currentRouteName = request()->route()->getName();
        $regions          = Region::all()->pluck('name', 'id')->toArray();
        $jobs             = Job::all()->pluck('job_name', 'id')->toArray();
        $nationalities    = Nationality::all()->pluck('name', 'id')->toArray();

        return view('front.labor_market.temp.index', compact('regions', 'jobs', 'nationalities', 'currentRouteName', 'occasionalWork'));
    }

    /**
     * @return mixed
     *
     * Offer to the provider offer from the benf
     */
    public function askOffer()
    {
        $id = request()->input('id');

        if (empty($id)) {
            return response(trans('temp_job.offer_not_chosen'), 405);
        }

        if (session()->get('selected_establishment')) {
            $user_id = session()->get('selected_establishment.id');
        } elseif (session()->get('government')) {
            $user_id = session()->get('government.id');
        } else {
            $user_id = auth()->user()->id_no;
        }

        $labors = HRPool::whereIn('id', explode(',', $id))->get();

        foreach ($labors as $labor) {
            if (!isset($contracts[$labor->provider_type][$labor->provider_id])) {
                $contracts[$labor->provider_type][$labor->provider_id] = Contract::create([
                    'contract_type_id' => Constants::CONTRACTTYPES['hire_labor'],
                    'provider_id'      => $labor->provider_id,
                    'provider_type'    => $labor->provider_type,
                    'benf_type'        => \Auth::user()->user_type_id,
                    'benf_id'          => $user_id,
                ]);
            }
            
            $contracts[$labor->provider_type][$labor->provider_id]->contractEmployee()->save(new ContractEmployee([
                'ishaar_id'  => Constants::CONTRACTTYPES['hire_labor'],
                'id_number'  => $labor->id,
                'start_date' => $labor->start_date,
                'end_date'   => $labor->end_date,
                'status'     => 'pending',
            ]));
        }

        return response(trans('temp_job.contract_applied'), 200);

    }

     /**
     * Display a listing of the Direct hiring
     * Labor Market .
     * @return \Illuminate\Http\Response
     */
    public function directHiringMarket()
    {
        if (request()->ajax()) {

            $query = HRPool::jobseeker()->byOthers()->checked()->with('job', 'nationality','region');
            $total_count = ($query->count()) ? $query->count() : 1;
            $columns     = request()->input('columns');


            $inputs = request()->only([
                'id',
                "gender",
                "religion",
                "nationality_id",
                "region_id",
                "job_type",
                "work_start_date",
                "work_end_date",
            ]);
            
            foreach ($inputs as $key => $input) {
                if (request()->input($key)) {
                    $query->where($key, $input);
                }
            }
            if (request()->input('provider_name')) {
                $query = $query->where(function ($provider_q) {
                    $provider_q->whereHas('establishment', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('provider_name') . '%');
                    });
                    $provider_q->orWhereHas('individual', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('provider_name') . '%');
                    });
                    $provider_q->orWhereHas('government', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('provider_name') . '%');
                    });

                });
            }

            if ($job_name = request()->input('job_name')) {
                $query->whereHas('job', function ($q) use ($job_name) {
                    return $q->where('job_name', 'LIKE', '%' . $job_name . '%');
                });
            }
            if ($name = request()->input('name')) {
                $query->where('name', 'LIKE', '%' . $name . '%');
                }
           

                $buttons = [
                    'show' => [
                        "text"      => trans("temp_job.offer_contract"),
                        "url"       => url("direct-hiring/send-offer"),
                        "css_class" => "blue",
                    ],
                ];

            return dynamicAjaxPaginate($query, $columns, $total_count, $buttons);

        }
        $regions          = Region::all()->pluck('name', 'id')->toArray();
        $jobs             = Job::all()->pluck('job_name', 'id')->toArray();
        $nationalities    = Nationality::all()->pluck('name', 'id')->toArray();

        return view('front.labor_market.direct_hiring.index', compact('regions', 'jobs', 'nationalities'));
    }


}
