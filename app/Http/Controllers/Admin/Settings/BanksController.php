<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Settings;

use Database;
use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\BanksRequest;
use Illuminate\Support\Facades\Route;
use Tamkeen\Ajeer\Models\Bank;

class BanksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::with('parentBank')->latest()->paginate(20);
		
        return view('admin.settings.banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$banks = Bank::get()->lists('name','id')->all();
		$banks = array(''=>trans('banks.select')) + $banks;
		
		return view('admin.settings.banks.edit', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BanksRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));

		$bank = new Bank();
		
		$bank->name = $request->name;
		if($request->parent_bank_id == ""){
			$bank->parent_bank_id = null;
		}else{
			$bank->parent_bank_id = $request->parent_bank_id;
		}
		
		$bank->save();
		
        return trans('banks.banksadded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        return $this->edit($bank);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$banks = Bank::get()->lists('name','id')->all();
		$banks = array(''=>trans('banks.select')) + $banks;
        $bank = Bank::byId($id)->firstOrFail();

        return view('admin.settings.banks.edit', compact('bank', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BanksRequest $request, $id)
    {
        $bank = Bank::byId($id)->firstOrFail();
        $data = $request->only(array_keys($request->rules()));
		
		$bank->name = $request->name;
		if($request->parent_bank_id == ""){
			$data['parent_bank_id'] = null;
		}else{
			$data['parent_bank_id'] = $request->parent_bank_id;
		}
		
        $bank->fill($data);
        $bank->save();

        return trans('banks.banksupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Bank::byId($id)->firstOrFail();
		
		$bank = Bank::byId($id)->with('childrenBank')->firstOrFail();
        if (count($bank->childrenBank)) {
            return response()->json(['error' => trans('banks.error_delete')], 422);
        }
		
        $bank->delete();

        return trans('banks.banksdeleted');
    }
}
