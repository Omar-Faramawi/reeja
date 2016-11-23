<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Activity;
use Tamkeen\Ajeer\Models\EstablishmentPermissionActivity;
use Tamkeen\Ajeer\Models\GovernmentPermissionActivity;
use Tamkeen\Ajeer\Models\IshaarIssueEstPerm;
use Tamkeen\Ajeer\Models\IshaarIssueGovernPerm;
use Tamkeen\Ajeer\Models\IshaarIssuePermissions;
use Tamkeen\Ajeer\Models\ServiceUsersPermission;
use Tamkeen\Ajeer\Http\Requests\EditNoticePermissionRequest;
use Vinkla\Hashids\Facades\Hashids;

class IshaarPermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        
    }
    
    /**
     * Display the specified resource.
     *  redirect show method to edit method
     *
     * @param  int $id
     *
     * redirect to edit method
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        $ishaarUserPerm = IshaarIssuePermissions::with([
            'estPermissions',
            'govPermissions',
        ])->firstOrCreate(['ishaar_setup_id' => Hashids::decode($id)[0]]);
        $activities     = Activity::pluck('name', 'id')->toArray();
        foreach ($activities as $key => $one) {
            $ishaarUserPerm->estPermissions()->firstOrCreate(['activity_id' => $key]);
            $ishaarUserPerm->govPermissions()->firstOrCreate(['activity_id' => $key]);
        }
        $est_activity = $ishaarUserPerm->estPermissions()->with('activity')->get();
        $gov_activity = $ishaarUserPerm->govPermissions()->with('activity')->get();
     
        return view('admin.temp_work.ishaar_permissions.edit',
            compact('ishaarUserPerm', 'activities', 'gov_activity', 'est_activity'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  EditNoticePermissionRequest $request
     * @param  int                         $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EditNoticePermissionRequest $request, $id)
    {

        $notice_permission = IshaarIssuePermissions::byId($id)->firstOrFail();
        $newData           = $request->only(array_keys($request->rules()));
        
        $notice_permission->update(array_except($newData, 'est_perm_activities'));
        
        // Establishments activities coming in the request
        $estReq = $request->get('est_perm_activities');
        // Government activities coming in the request
        $govReq = $request->get('gover_activities');

        foreach ($estReq as $value) {
            $est_record = IshaarIssueEstPerm::firstOrNew([
                'ishaar_issue_permission_id' => Hashids::decode($id),
                'activity_id'                => $value['activity_id'],
            ]);
            if (!isset($est_record->id)) {
                $est_record->created_by = auth()->id();
                $est_record->fill($value);
                $est_record->save();
            } else {
                $est_record->update($value);
                $est_record->save();
            }
        }

        foreach ($govReq as $value) {
            $gov_record = IshaarIssueGovernPerm::firstOrNew([
                'ishaar_issue_permission_id' => Hashids::decode($id),
                'activity_id'                => $value['activity_id'],
            ]);
            if (!isset($gov_record->id)) {
                $gov_record->created_by = auth()->id();
                $gov_record->fill($value);
                $gov_record->save();
            } else {
                $gov_record->update($value);
                $gov_record->save();
            }
        }

        return trans('ishaar_permissions.ishaar_permissions_saved');
    }
}
