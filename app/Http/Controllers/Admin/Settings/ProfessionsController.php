<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\JobSearchRequest;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Repositories\MOL\MolDataRepository;

class ProfessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MolDataRepository $mol)
    {
        $data = Job::with('nationalities')->latest()->paginate(20);
        $nationalities = Nationality::pluck('name', 'id')->toArray();

        return view('admin.settings.professions.list', compact('data', 'nationalities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $data)
    {
        // Get the form data
        $nations = $data->get('nations', []);

        // Update all of the page results because of the deactivation
        $professions = Job::latest()->paginate(20, ['*'], 'page', $data->get('page'));
        foreach ($professions as $one) {
            $nations[$one->hashids] = empty($nations[$one->hashids]) ? [] : $nations[$one->hashids];
            $one->nationalities()->sync($nations[$one->hashids]);
            $one->save();
        }

        return trans('professions.updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param JobSearchRequest $request
     */
    public function search(JobSearchRequest $request)
    {
        $data = Job::where('job_name', 'LIKE', '%' . $request->q . "%")->with('nationalities')->latest()->paginate(20);
        $nationalities = Nationality::pluck('name', 'id')->toArray();

        return view('admin.settings.professions.listforsearch', compact('data', 'nationalities'));
    }

    public function updateForSearch(Request $data)
    {
        // Get the form data
        $nations = $data->get('nations', []);
        // Update all of the page results because of the deactivation
        foreach ($data->job_id as $newData) {
            $job = Job::byId($newData)->first();
            $nations[$newData] = empty($nations[$newData]) ? [] : $nations[$newData];
            $job->nationalities()->sync($nations[$job->hashids]);
            $job->save();
        }


        return trans('professions.updated');
    }
}
