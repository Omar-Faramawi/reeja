<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Models\UserTypes;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\UserTypesRequest;
use Tamkeen\Ajeer\Http\Controllers\Controller;

class UserTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserTypes::latest()->paginate(20);
        
        return view('admin.users.user_types.list', compact('data'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.user_types.edit');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Tamkeen\Ajeer\Http\Requests\UserTypesRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserTypesRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));
        UserTypes::create($data);
        
        return trans('user_types.added');
    }
    
    /**
     * Display the specified resource.
     *
     * @param $id
     */
    public function show($id)
    {
        $this->edit($id);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = UserTypes::byId($id)->firstOrFail();
        
        return view('admin.users.user_types.edit', compact('data'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param Request|UserTypesRequest $request
     * @param                          $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserTypesRequest $request, $id)
    {
        $data        = UserTypes::byId($id)->firstOrFail();
        $update_data = $request->only(array_keys($request->rules()));
        $data->fill($update_data);
        $data->save();
        
        return trans('user_types.updated');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = UserTypes::byId($id)->with('users')->firstOrFail();
        if (count($data->users)) {
            return response()->json(['error' => trans('user_types.error_delete')], 422);
        }
        $data->delete();
        
        return trans('user_types.deleted');
    }
}
