<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Vacancy;
use Tamkeen\Ajeer\Models\VacancyLocations;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\BaseModel;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\VacanciesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VacanciesController extends Controller
{
    /**
     * Show the Vacancies Layout.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $vacancies   = Vacancy::byMe()->notSeasonal();
            $total_count = ($vacancies->count()) ? $vacancies->count() : 1;
            $columns     = request()->input('columns');
            if (request()->input('id')) {
                $vacancies = $vacancies->where('id', request()->input('id'));
            }
            if (request()->input('job')) {
                $vacancies = $vacancies->whereHas('job', function ($job_q) {
                    $job_q->where('job_name', 'LIKE', '%' . request()->input('job') . '%');
                });
            }
            if (request()->input('region')) {
                $vacancies = $vacancies->whereHas('region', function ($reg_q) {
                    $reg_q->where('name', 'LIKE', '%' . request()->input('region') . '%');
                });
            }
            if (request()->input('no_of_vacancies')) {
                $vacancies = $vacancies->where('no_of_vacancies', request()->input('no_of_vacancies'));
            }
            $vacancies = $vacancies->with(['job', 'region']);
            $buttons   = [
                'view' => [],
                'edit' => [
                    "text"      => trans("labels.edit"),
                    "url"       => url("/vacancies"),
                    "uri"       => "edit",
                    "css_class" => "blue",
                ],
            ];
            
            return dynamicAjaxPaginate($vacancies, $columns, $total_count, $buttons);
        }

        return view('front.vacancies.index');
    }

    /**
     * Show Only One Vacancy.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        
        return view('front.vacancies.show_details', compact('vacancy'));
    }

    public function create()
    {
        $taeed_vacancies = Vacancy::byMe()->seasonal()->whereNull('nationality_id')->latest()->get();

        $jobs          = Job::all(['id', 'job_name']);
        $regions       = Region::all(['id', 'name']);
        $nationalities = Nationality::all(['id', 'name']);

        return view('front.vacancies.add', compact('jobs', 'regions', 'nationalities', 'taeed_vacancies'));
    }

    /**
     * Store a new Vacancy.
     *
     * @param Request|VacanciesRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(VacanciesRequest $request)
    {
        if (session()->get('selected_establishment')) {
            $benef_id = session()->get('selected_establishment.id');
        } elseif (session()->get('government')) {
            $benef_id = session()->get('government.id');
        } else {
            $benef_id = Auth::user()->id_no;
        }

        $data              = $request->only(array_keys($request->rules()));
        $data['benf_id']   = $benef_id;
        $data['benf_type'] = \Auth::user()->user_type_id;
        $data['status']    = 1;
        if (!$data['hide_salary']) {
            $data['hide_salary'] = '0';
        }
        $save              = Vacancy::create($data);
        if ($request->work_areas) {
            $add               = new VacancyLocations;
            $add->location     = $request->work_areas;
            $add->vacancies_id = $save->id;
            $add->save();
        }

        return trans('vacancies.success_data');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $vacancy       = Vacancy::findorfail($id);
        $jobs          = Job::all(['id', 'job_name']);
        $regions       = Region::all(['id', 'name']);
        $nationalities = Nationality::all(['id', 'name']);

        return view('front.vacancies.edit', compact('vacancy', 'jobs', 'regions', 'nationalities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VacanciesRequest $request
     *
     * @return string
     * @internal param int $id
     *
     */
    public function update(VacanciesRequest $request, $id)
    {
        $data = $request->only(array_keys($request->rules()));
        $update = Vacancy::findOrFail($id)->update($data);
        if ($request->work_areas) {
            $add = new VacancyLocations;
            $add->location = $request->work_areas;
            $add->vacancies_id = $id;
            $add->save();
        }

        return trans('vacancies.success_update');
    }
}
