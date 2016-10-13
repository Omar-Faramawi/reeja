<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Activity;
use Tamkeen\Ajeer\Models\EstablishmentPermissionActivity;
use Tamkeen\Ajeer\Models\GovernmentPermissionActivity;
use Tamkeen\Ajeer\Models\ServiceUsersPermission;
use Tamkeen\Ajeer\Http\Requests\EditServiceUsersPermissionsRequest;
use Vinkla\Hashids\Facades\Hashids;

class ServiceUsersPermissionsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Establishment and Individual permitted activities
        $serviceUserPerm = ServiceUsersPermission::whereContractTypeId(Hashids::decode($id))->withTrashed()->get();
        
        // Establishment permissions object data
        $estServ = $serviceUserPerm[0];
        $serUserPermId = $estServ->id;

        // Indv permissions object data
        $indvServ = $serviceUserPerm[1];

        $activities = Activity::orWhereHas('establishments', function ($q) use ($serUserPermId) {
            $q->where('service_users_permission_id', '=', $serUserPermId);
        })->with(['governments',
            'establishments' => function ($q) use ($serUserPermId) {
                $q->where('service_users_permission_id', '=', $serUserPermId);
            }
        ])->get();

        $activities = $activities->toArray() + Activity::all()->toArray();
        return view('admin.taqawel.service_users_permissions.edit',
            compact('estServ', 'indvServ', 'activities', 'serUserPermId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditServiceUsersPermissionsRequest $request, $id)
    {
        $newData = $request->only(array_keys($request->rules()));

        // Establishments activities coming in the request
        $estReq = $request->get('est_perm_activities');

        // Government activities coming in the request
        $govReq = $request->get('gover_activities');
        // Checks if the activity permission exists in the DB, if so, it will be updated, if not, it will be created.
        foreach ($estReq as $value) {
            $est_record = EstablishmentPermissionActivity::firstOrNew([
                'service_users_permission_id' => $value['service_users_permission_id'],
                'activity_id'                 => $value['activity_id'],
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
        // Checks if the activity permission exists in the DB, if so, it will be updated, if not, it will be created.
        foreach ($govReq as $value) {
           if (array_key_exists('service_users_permission_id', $value)) {
                $gres = GovernmentPermissionActivity::where('activity_id',$value['activity_id'])->first();
                // Remove unchecked activities
                if ($gres) {
                    $gres->update(['service_users_permission_id' => $value['service_users_permission_id']]);
                }else{
                    GovernmentPermissionActivity::Create([
                    'service_users_permission_id' => $value['service_users_permission_id'],
                    'activity_id'                 => $value['activity_id'],
                    'created_by'                  => auth()->id()
                ]);
                }
            } else {
                GovernmentPermissionActivity::where('activity_id',$value['activity_id'])->delete();
            }
        }


        $estServ = ServiceUsersPermission::where('service_prvdr_benf_id',
            1)->with('estPermActivities')->withTrashed()->first();
        $indvServ = ServiceUsersPermission::where('service_prvdr_benf_id', 3)->withTrashed()->first();

        if ($request->get('indvIsProvider')) {
            if ($indvServ->trashed()) {
                $indvServ->restore();
                $indvServ->save();
                $indvServ->update(['benf_indv' => $request->get('benf_indv_from_est')]);
            }
        } else {
            if (!$indvServ->trashed()) {
                $indvServ->benf_indv = 0;
                $indvServ->save();
                $indvServ->delete();
                $indvServ->update(['benf_indv' => 0]);
            }
        }

        //
        if ($request->get('estIsProvider')) {
            $estServ->restore();
            $estServ->update($newData);
        } else {
            $estServ->delete();
        }


        return trans('service_users_permissions.service_users_permissions_saved');
    }
}

