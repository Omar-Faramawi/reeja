<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\EditServiceUsersPermissionsRequest;
use Tamkeen\Ajeer\Models\Activity;
use Tamkeen\Ajeer\Models\EstablishmentPermissionActivity;
use Tamkeen\Ajeer\Models\GovernmentPermissionActivity;
use Tamkeen\Ajeer\Models\ServiceUsersPermission;
use Tamkeen\Ajeer\Utilities\Constants;
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

        // Indv permissions object data
        $govServ = $serviceUserPerm[2];

        $oldActivities = Activity::orWhereHas('establishments', function ($q) use ($serUserPermId) {
            $q->where('service_users_permission_id', '=', $serUserPermId);
        })->with([
            'governments',
            'establishments' => function ($q) use ($serUserPermId) {
                $q->where('service_users_permission_id', '=', $serUserPermId);
            }
        ])->get();

        $activities = $oldActivities->toArray() + Activity::all()->toArray();
        $filterActivites = $oldActivities->pluck('name', 'name')->toArray() + Activity::all()->pluck('name',
                'name')->toArray();
        return view('admin.taqawel.service_users_permissions.edit',
            compact('estServ', 'indvServ', 'govServ', 'activities', 'serUserPermId', 'filterActivites'));
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
                $gres = GovernmentPermissionActivity::where('activity_id', $value['activity_id'])->first();
                // Remove unchecked activities
                if ($gres) {
                    $gres->update(['service_users_permission_id' => $value['service_users_permission_id']]);
                } else {
                    GovernmentPermissionActivity::Create([
                        'service_users_permission_id' => $value['service_users_permission_id'],
                        'activity_id'                 => $value['activity_id'],
                        'created_by'                  => auth()->id()
                    ]);
                }
            } else {
                GovernmentPermissionActivity::where('activity_id', $value['activity_id'])->delete();
            }
        }


        $estServ = ServiceUsersPermission::where('service_prvdr_benf_id',
            1)->with('estPermActivities')->withTrashed()->first();
        $indvServ = ServiceUsersPermission::where('service_prvdr_benf_id', 3)->withTrashed()->first();
        $govServ = ServiceUsersPermission::whereContractTypeId(Constants::CONTRACTTYPES['taqawel'])->where('service_prvdr_benf_id',
            2)->withTrashed()->first();

        if ($request->get('indvIsProvider')) {
            if ($indvServ->trashed()) {
                $indvServ->restore();
                $indvServ->save();
                $indvServ->update(['benf_indv' => 1]);
            }
        } else {
            if (!$indvServ->trashed()) {
                $indvServ->benf_indv = 0;
                $indvServ->save();
                $indvServ->delete();
                $indvServ->update(['benf_indv' => 0]);
            }
        }
        if ($request->get('govIsProvider')) {
            if ($govServ->trashed()) {
                $govServ->restore();
                $govServ->save();
                $govServ->update(['benf_gover' => 1]);
            }
        } else {
            if (!$govServ->trashed()) {
                $govServ->benf_gover = 0;
                $govServ->save();
                $govServ->delete();
                $govServ->update(['benf_gover' => 0]);
            }
        }

        //
        if ($request->get('estIsProvider')) {
            $estServ->restore();
            $estServ->update(array_except($newData, 'est_perm_activities'));
        } else {
            $estServ->delete();
        }


        return trans('service_users_permissions.service_users_permissions_saved');
    }
}

