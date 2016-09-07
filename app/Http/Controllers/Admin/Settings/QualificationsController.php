<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Database;
use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\QualificationsRequest;
use Illuminate\Support\Facades\Route;
use Tamkeen\Ajeer\Models\Qualification;

class QualificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qualifications = Qualification::latest()->paginate(20);

        return view('admin.settings.qualifications.index', compact('qualifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.qualifications.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QualificationsRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));

        Qualification::create($data);

        return trans('qualifications.qualificationadded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Qualification $qualification)
    {
        return $this->edit($qualification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $qualification = Qualification::byId($id)->firstOrFail();

        return view('admin.settings.qualifications.edit', compact('qualification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QualificationsRequest $request, $id)
    {
        $qualification = Qualification::byId($id)->firstOrFail();
        $data = $request->only(array_keys($request->rules()));
        $qualification->fill($data);
        $qualification->save();

        return trans('qualifications.qualificationupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $qualification = Qualification::byId($id)->firstOrFail();
        $qualification->delete();
        
        return trans('qualifications.qualificationdeleted');
    }
}
