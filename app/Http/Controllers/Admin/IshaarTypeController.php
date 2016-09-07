<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\IshaarTypesRequest;
use Tamkeen\Ajeer\Models\IshaarType;

class IshaarTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = IshaarType::latest()->paginate(20);

        return view('admin.ishaars.types.lists', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ishaars.types.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|IshaarTypesRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(IshaarTypesRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));
        IshaarType::create($data);

        return trans('ishaar_types.added');
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
        $data = IshaarType::byId($id)->firstOrFail();

        return view('admin.ishaars.types.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request|IshaarTypesRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(IshaarTypesRequest $request, $id)
    {
        $updatedData = $request->only(array_keys($request->rules()));
        $updated = IshaarType::byId($id)->update($updatedData);

        if ($updated) {
            return trans('ishaar_types.updated');
        }

        return trans('ishaar_types.updated_error');
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
        $data = IshaarType::byId($id)->with('setups')->firstOrFail();

        if (count($data->setups)) {
            return response()->json(['error' => trans('ishaar_types.error_delete')], 422);
        }

        $data->delete();

        return trans('ishaar_types.deleted');
    }
}
