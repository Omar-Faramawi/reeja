<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\ProfessionsRequest;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Repositories\MOL\MolDataRepository;
use Tamkeen\Ajeer\Http\Controllers\Controller;

class ProfessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MolDataRepository $mol)
    {
        // Connecting to MOL and retrieve the professions list
        $professions = $mol->fetchJobsLookup(false);
        foreach ($professions as $profession) {
            Job::firstOrCreate(['job_name' => $profession['name']]);
        }
        
        $data          = Job::with('nationalities')->latest()->paginate(20);
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
}
