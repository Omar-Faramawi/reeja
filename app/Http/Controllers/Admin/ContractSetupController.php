<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Models\Activity;
use Tamkeen\Ajeer\Models\ContractSetup;
use Tamkeen\Ajeer\Http\Requests\CreateUpdateContractSetupRequest;
use Tamkeen\Ajeer\Http\Requests\CreateUpdateTaqawelContractSetupRequest;
use Tamkeen\Ajeer\Models\EstablishmentPermissionActivity;
use Tamkeen\Ajeer\Models\ServiceUserPermission;
use Vinkla\Hashids\Facades\Hashids;

class ContractSetupController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contractSetup = ContractSetup::byId($id)->firstOrFail();

        return view('admin.' . config('paths.contract_setup.view.' . $contractSetup->id) . '.edit',
            compact('contractSetup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateUpdateContractSetupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateContractSetupRequest $request)
    {
        $newData = $request->only(array_keys($request->rules()));
        $contractSetup = ContractSetup::where('contract_type_id', '=', $newData['contract_type_id'])->firstOrFail();

        $setupSaved = $contractSetup->update($newData);

        return ($setupSaved) ? trans('contract_setup.contract_setup_saved') : trans('contract_setup.contract_setup_not_saved');
    }

    /**
     * @param CreateUpdateTaqawelContractSetupRequest $request
     * @param $id
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function updateTaqawel(CreateUpdateTaqawelContractSetupRequest $request, $id)
    {
        $newData = $request->only(array_keys($request->rules()));
        $contractSetup = ContractSetup::where('contract_type_id', '=', $newData['contract_type_id'])->firstOrFail();

        $setupSaved = $contractSetup->update($newData);

        return ($setupSaved) ? trans('contract_setup.contract_setup_saved') : trans('contract_setup.contract_setup_not_saved');
    }
}
