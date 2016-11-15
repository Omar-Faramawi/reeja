<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\SaudiPercentageRequest;
use Tamkeen\Ajeer\Models\Activity;
use Tamkeen\Ajeer\Models\PermissionActivity;
use Tamkeen\Ajeer\Models\SaudiPercentage;
use Tamkeen\Ajeer\Models\Size;

class SaudiPercentageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SaudiPercentage::latest()->paginate(20);
        $sizes      = Size::lists('name', 'id')->toArray();
        $activities = Activity::lists('name', 'id')->toArray();

        return view('admin.taqawel.saudi_percentage.index', compact('data','sizes','activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sizes      = Size::lists('name', 'id')->toArray();
        $activities = Activity::lists('name', 'id')->toArray();

        return view('admin.taqawel.saudi_percentage.edit', compact('data', 'sizes', 'activities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaudiPercentageRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function store(SaudiPercentageRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));

        // todo: get contract_type_id from the table, we will hard code it for now
        $data['contract_type_id'] = 1;
        SaudiPercentage::create($data);

        return trans('saudi_percentage.added');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = SaudiPercentage::byId($id)->firstOrFail();

        $sizes      = Size::lists('name', 'id')->toArray();
        $activities = Activity::lists('name', 'id')->toArray();

        return view('admin.taqawel.saudi_percentage.edit', compact('data', 'sizes', 'activities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaudiPercentageRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     * @internal param $SaudiPercentageRequest
     */
    public function update(SaudiPercentageRequest $request, $id)
    {
        $data        = SaudiPercentage::byId($id)->firstOrFail();
        $update_data = $request->only(array_keys($request->rules()));
        $data->fill($update_data);
        $data->save();

        return trans('saudi_percentage.updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = SaudiPercentage::byId($id)->firstOrFail();
        $data->delete();

        return trans('saudi_percentage.deleted');
    }

}
