<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Database;
use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\NationalityRequest;
use Illuminate\Support\Facades\Route;
use Tamkeen\Ajeer\Models\Nationality;

class NationalitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nationalities = Nationality::latest()->paginate(20);

        return view('admin.settings.nationalities.index', compact('nationalities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.nationalities.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NationalityRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));

        Nationality::create($data);

        return trans('nationalities.nationalityadded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Nationality $nationality)
    {
        return $this->edit($nationality);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nationality = Nationality::byId($id)->firstOrFail();

        return view('admin.settings.nationalities.edit', compact('nationality'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NationalityRequest $request, $id)
    {
        $nationality = Nationality::byId($id)->firstOrFail();
        $data = $request->only(array_keys($request->rules()));
        $nationality->fill($data);
        $nationality->save();

        return trans('nationalities.nationalityupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $nationality = Nationality::byId($id)->firstOrFail();
        $nationality->delete();
        return trans('nationalities.nationalitydeleted');
    }
}
