<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Database;
use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\ExperiencesRequest;
use Illuminate\Support\Facades\Route;
use Tamkeen\Ajeer\Models\Experience;

class ExperiencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experiences = Experience::latest()->paginate(20);

        return view('admin.settings.Experiences.index', compact('experiences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.Experiences.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExperiencesRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));

        Experience::create($data);

        return trans('experiences.experienceadded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Experience $experience)
    {
        return $this->edit($experience);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $experience = Experience::byId($id)->firstOrFail();

        return view('admin.settings.Experiences.edit', compact('experience'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExperiencesRequest $request, $id)
    {
        $experience = Experience::byId($id)->firstOrFail();
        $data = $request->only(array_keys($request->rules()));
        $experience->fill($data);
        $experience->save();

        return trans('experiences.experienceupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $experience = Experience::byId($id)->firstOrFail();
        $experience->delete();

        return trans('experiences.experiencedeleted');
    }
}
