<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\OccupationManagementRequest;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Attachment;
use Tamkeen\Ajeer\Http\Controllers\Controller;

class OccupationManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data        = Job::with('attachments')->latest()->paginate(20);
        $attachments = Attachment::get()->lists('name', 'id')->all();
        
        return view('admin.settings.occupation_managment.list', compact('data', 'attachments'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $data)
    {
        // Get Form Data
        $attachment_mandatory = $data->get('attachment_mandatory', []);
        $attachment_ids       = $data->get('attachment_id', []);
        
        // Update all of the page results because of the deactivation
        $professions = Job::latest()->paginate(20, ['*'], 'page', $data->get('page'));
        foreach ($professions as $one) {
            $one->attachment_mandatory = empty($attachment_mandatory[$one->hashids]) ? '0' : '1';
            if (isset($attachment_ids[$one->hashids][0]) && $attachment_ids[$one->hashids][0] != '') {
                $one->attachments()->sync($attachment_ids[$one->hashids]);
            }
            $one->save();
        }
        
        return trans('professions.updated');
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
        //
    }
}
