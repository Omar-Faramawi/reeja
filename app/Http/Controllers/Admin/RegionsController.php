<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\RegionsRequest;
use Tamkeen\Ajeer\Models\Region;

class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // exclude the default regions from the database
        $data = Region::where('id', '>', 2)->latest()->paginate(20);
        
        return view('admin.ishaars.regions.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ishaars.regions.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|RegionsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RegionsRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));
        Region::create($data);

        return trans('regions.added');
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
        $this->edit($id);
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
        $data = Region::byId($id)->firstOrFail();

        return view('admin.ishaars.regions.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|RegionsRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RegionsRequest $request, $id)
    {
        $updatedData = $request->only(array_keys($request->rules()));
        $updated     = Region::byId($id)->update($updatedData);

        if ($updated) {
            return trans('regions.updated');
        }

        return trans('regions.updated_error');
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
        $data = Region::byId($id)->with('ishaar_setups')->firstOrFail();

        if ($data->ishaar_setups->count() > 0) {
            return response()->json(['error' => trans('regions.error_delete')], 422);
        }

        $data->delete();

        return trans('regions.deleted');
    }
}
