<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Database;
use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\ReasonsRequest;
use Illuminate\Support\Facades\Route;
use Tamkeen\Ajeer\Models\Reason;

class ReasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reasons = Reason::where('id', '>', 2)->active()->with('parentReason')->latest()->paginate(20);
        
        return view('admin.settings.reasons.index', compact('reasons'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reasons = Reason::where('id', '<', 2)->get()->lists('reason', 'id')->all();
        
        return view('admin.settings.reasons.edit', compact('reasons'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  ReasonsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ReasonsRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));
        
        $reason = new Reason();
        
        $reason->reason = $request->reason;
        if ($request->parent_id == "") {
            $reason->parent_id = null;
        } else {
            $reason->parent_id = $request->parent_id;
        }
        $reason->status = 1;
        
        $reason->save();
        
        return trans('reasons.reasonsadded');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  Reason $reason
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Reason $reason)
    {
        return $this->edit($reason);
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
        $reasons = Reason::where('id', '<', 2)->get()->lists('reason', 'id')->all();
        $reason  = Reason::byId($id)->firstOrFail();
        
        return view('admin.settings.reasons.edit', compact('reason', 'reasons'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  ReasonsRequest $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ReasonsRequest $request, $id)
    {
        $reason = Reason::byId($id)->firstOrFail();
        $data   = $request->only(array_keys($request->rules()));
        
        $reason->reason = $request->reason;
        if ($request->parent_id == "") {
            $data['parent_id'] = null;
        } else {
            $data['parent_id'] = $request->parent_id;
        }
        
        $reason->fill($data);
        $reason->save();
        
        return trans('reasons.reasonsupdated');
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
        $reason = Reason::byId($id)->firstOrFail();
        
        $reason = Reason::byId($id)->with('childrenReason')->firstOrFail();
        if (count($reason->childrenReason)) {
            return response()->json(['error' => trans('reasons.error_delete')], 422);
        }
        
        $reason->delete();
        
        return trans('reasons.reasonsdeleted');
    }
}
