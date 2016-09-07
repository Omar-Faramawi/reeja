<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Models\Experience;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\Qualification;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Utilities\Constants;

class CVController extends Controller
{
    // Editing the user CV
    public function edit()
    {
        $user = auth()->user();
        $data = HRPool::me()->first();
        
        // Extracts the first character from the National ID
        $nidChar = substr($user->national_id, 0, 1);
        
        $nationalities = Nationality::all();
        
        // Regions depending on whether the user is not Muslim or not saudi and visitor
        if ($data->religion != 1) {
            $regions = Region::where('id', '!=', 1)->lists('name', 'id');
        } elseif (!in_array($nidChar, [1, 2])) {
            $regions = Region::whereId(1)->lists('name', 'id');
        } else {
            $regions = Region::lists('name', 'id');
        }
        
        $jobs = Job::whereHas('nationalities', function ($nat_q) use ($data) {
            $nat_q->where('nationalities.id', $data->nationality_id);
        })->lists('job_name', 'id');
        
        $qualifications = Qualification::lists('name', 'id');
        $experiences    = Experience::lists('name', 'id');
        
        return view('front.cv.edit',
            compact('data', 'nationalities', 'regions', 'jobs', 'qualifications', 'experiences', 'indvLabor'));
    }
    
    // Updating the user CV
    
    public function update(Requests\UpdateCVRequest $request)
    {
        $data   = $request->only(array_keys($request->rules()));
        $record = HRPool::byId($request->get('dataId'))->firstOrFail();
        
        // Checking if the user pressed "Save and complete later" button.
        if ($request->has('later')) {
            $data['chk'] = 0;
        } else {
            $data['chk'] = 1;
        }
        
        $record->update($data);
        
        return trans('cv_publishment.saved');
    }
}
