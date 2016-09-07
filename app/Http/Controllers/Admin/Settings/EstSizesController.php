<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Database;
use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\EstSizesRequest;
use Illuminate\Support\Facades\Route;
use Tamkeen\Ajeer\Models\EstablishmentSize;

class EstSizesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $est_sizes = EstablishmentSize::latest()->paginate(20);

        return view('admin.settings.est_sizes.index', compact('est_sizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.est_sizes.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstSizesRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));

        EstablishmentSize::create($data);

        return trans('est_sizes.est_sizeadded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EstablishmentSize $est_size)
    {
        return $this->edit($est_size);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $est_size = EstablishmentSize::byId($id)->firstOrFail();

        return view('admin.settings.est_sizes.edit', compact('est_size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EstSizesRequest $request, $id)
    {
        $est_size = EstablishmentSize::byId($id)->firstOrFail();
        $data = $request->only(array_keys($request->rules()));
        $est_size->fill($data);
        $est_size->save();

        return trans('est_sizes.est_sizeupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $est_size = EstablishmentSize::byId($id)->firstOrFail();
        $est_size->delete();
        
        return trans('est_sizes.est_sizedeleted');
    }
}