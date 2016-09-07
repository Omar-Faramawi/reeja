<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\LoanPcntRequest;
use Tamkeen\Ajeer\Models\EstablishmentSize;
use Tamkeen\Ajeer\Http\Requests;

class LoanPcntController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loan_pcnts = EstablishmentSize::latest()->get();

        return view('admin.temp_work.loan_pcnt.index', compact('loan_pcnts'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param LoanPcntRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(LoanPcntRequest $request)
    {
        $percentages = $request->only(array_keys($request->rules()));

        foreach ($request->input('percentages') as $key => $percent) {
            EstablishmentSize::findOrFail($key)->update(['pct_hire_labor_tmp_work' => $percent]);
        }

        return trans('loan_pcnt.updated');
    }

}
