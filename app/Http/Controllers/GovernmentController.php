<?php

namespace Tamkeen\Ajeer\Http\Controllers;

use Illuminate\Http\Request;

use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\UpdateGovResponsiblesRequest;
use Tamkeen\Ajeer\Models\Government;
use Tamkeen\Ajeer\Models\GovResponsible;

class GovernmentController extends Controller
{
    /**
     * Get current establishment info
     */
    public function edit()
    {
        $gov = Government::find(session('government')->id);
        if (is_null($gov)) {
            return abort(404);
        }

        return view('front.government.profile', compact('gov'));
    }

    public function update(UpdateGovResponsiblesRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));
        if (count($data['resp_data']) < 1) {
            return response()->json(['errors' => trans('gov_profile.at_least_one')], 422);
        }

        foreach ($data['resp_data'] as $key => $value) {
            if (isset($value['id'])) {
                GovResponsible::find($value['id'])->update(array_except($value, 'id'));
            } else {
                $value['government_id'] = session('government')->id;
                $resp  = new GovResponsible();
                $resp->fill($value);
                $resp->save();
            }
        }

        if (request()->ajax()) {
            return trans('gov_profile.updated');
        }

        return redirect()->back()->withInput();
    }
}
