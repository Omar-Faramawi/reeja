<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Database;
use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\AttachmentsRequest;
use Illuminate\Support\Facades\Route;
use Tamkeen\Ajeer\Models\Attachment;

class AttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attachments = Attachment::latest()->paginate(20);

        return view('admin.settings.attachments.index', compact('attachments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.attachments.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttachmentsRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));

        Attachment::create($data);

        return trans('attachments.attachmentadded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Attachment $attachment)
    {
        return $this->edit($attachment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attachment = Attachment::byId($id)->firstOrFail();

        return view('admin.settings.attachments.edit', compact('attachment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttachmentsRequest $request, $id)
    {
        $attachment = Attachment::byId($id)->firstOrFail();
        $data = $request->only(array_keys($request->rules()));
        $attachment->fill($data);
        $attachment->save();

        return trans('attachments.attachmentupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attachment = Attachment::byId($id)->firstOrFail();
        $attachment->delete();
        
        return trans('attachments.attachmentdeleted');
    }
}
