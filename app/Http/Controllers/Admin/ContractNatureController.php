<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\ContractNature;
use Tamkeen\Ajeer\Http\Requests\ContractNatureRequest;

class ContractNatureController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contractsNatures = ContractNature::latest()->paginate(20);

        return view("admin.contract_nature.index", compact("contractsNatures"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view("admin.contract_nature.edit");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContractNatureRequest $contractNatureRequest
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ContractNatureRequest $contractNatureRequest)
    {
        $data = $contractNatureRequest->only(array_keys($contractNatureRequest->rules()));
        ContractNature::create($data);

        return trans("contractnature.sumbitedsucc");
    }

    /**
     * Display the specified resource.
     *  redirect show method to edit method
     * @param  int $id
     *
     * redirect to edit method
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return $this->edit($id);
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
        $contractNature = ContractNature::byId($id)->firstOrFail();

        return view("admin.contract_nature.edit", compact("contractNature"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContractNatureRequest $contractNatureRequest
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ContractNatureRequest $contractNatureRequest, $id)
    {
        $contractNature = ContractNature::byId($id)->firstOrFail();
        $data = $contractNatureRequest->only(array_keys($contractNatureRequest->rules()));
        $contractNature->update($data);

        return trans("contractnature.updated");
    }

    /**
     * check child Rows
     * return error if has any childs
     * if not soft delete resource
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ContractNature::byId($id)->with('marketTaqawoulServices')->firstOrFail();
        if (count($data->marketTaqawoulServices)) {
            return response()->json(['error' => trans('contractnature.error_delete')], 422);
        }
        $data->delete();

        return trans("contractnature.deleted");
    }

    /**
     * Method To activate or disactivate contact natures
     * get id of the contract nature request
     * toggle status
     * @param Request $request
     *
     * @return string
     */
    public function approve(Request $request)
    {
        $status = ContractNature::byId($request->get("id"))->firstOrFail();
        if ($request->get('type') == "approve") {
            $status->status = "1";
            $returned = trans("contractnature.activated");
        } else {
            $status->status = "0";
            $returned = trans("contractnature.stopactivated");
        }
        $status->save();

        return $returned;
    }

}
