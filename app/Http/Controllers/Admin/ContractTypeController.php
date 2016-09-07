<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\ContractType;
use Tamkeen\Ajeer\Http\Requests\ContractTypeRequest;

class ContractTypeController  extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contractsTypes = ContractType::latest()->paginate(20);

        return view("admin.contract_type.index", compact("contractsTypes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.contract_type.edit");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContractTypeRequest $contractTypeRequest
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function store(ContractTypeRequest $contractTypeRequest)
    {
        $data = $contractTypeRequest->only(array_keys($contractTypeRequest->rules()));
        ContractType::create($data);

        return trans("contracttype.sumbitedsucc");
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
        $contractsTypes = ContractType::byId($id)->firstOrFail();

        return view("admin.contract_type.edit", compact("contractsTypes"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ContractTypeRequest $contractTypeRequest, $id)
    {
        $contractType = ContractType::byId($id)->firstOrFail();
        $data = $contractTypeRequest->only(array_keys($contractTypeRequest->rules()));
        $contractType->update($data);

        return trans("contracttype.updated");
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
        $data = ContractType::byId($id)->with('setup')->firstOrFail();
        if (count($data->setup)) {
            return response()->json(['error' => trans('contracttype.error_delete')], 422);
        }
        $data->delete();

        return trans("contracttype.deleted");
    }

    /**
     * Method To activate or disactivate contact types
     * get id of the contract type request
     * toggle status
     * @param Request $request
     *
     * @return activated or disactivated message
     */
    public function approve(Request $request)
    {
        $status = ContractType::byId($request->get("id"))->firstOrFail();
        if ($request->get('type') == "approve") {
            $status->status = "1";
            $returned = trans("contracttype.activated");
        } else {
            $status->status = "0";
            $returned = trans("contracttype.stopactivated");
        }
        $status->save();

        return $returned;
    }

}
