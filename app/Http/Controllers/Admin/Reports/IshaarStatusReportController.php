<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Utilities\Constants;

class IshaarStatusReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.ishaar-status-report.index');
    }

    public function ishaarStatusReportChart($startDate = null, $endDate = null)
    {
    	session(['startDate' => $startDate]);
        session(['endDate' => $endDate]);

    	$data = DB::table('contract_employees')
    			  ->selectRaw('status, COUNT(status) as total');
              

        if(! empty($startDate) && ! empty($endDate)) {
            $data = $data->whereBetween('contract_employees.start_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                         ->orWhereBetween('contract_employees.end_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        }
    
        $data = $data->groupBy('status')->get();

        $returnedData = [];
        foreach ($data as $item) {
            $returnedData[] = [
                'statusName'  => trans("contracts.statuses.".$item->status),
                'statusValue' => $item->total,
                'sourceField' => $item->status
            ];
        }

        return $returnedData;
    }

    public function getIshaarByIshaarStatus($status)
    {
    	$startDate = session('startDate');
    	$endDate = session('endDate');

    	$ishaars = ContractEmployee::where("status", $status)->with('contract');

    	if(! empty($startDate) && ! empty($endDate)) {
            $ishaars = $ishaars->whereBetween('start_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                         ->orWhereBetween('end_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        }

        $ishaars = $ishaars->get();
        $data = [];
        foreach ($ishaars as $ishaar) {
            $data[] = [
                $ishaar->id,
               	$ishaar->contract->providername,
               	$ishaar->contract->benf_name,
               	trans("contracts.statuses.".$ishaar->status)
            ];

        }
        $returned = ['data' => $data];

        return response()->json($returned);
    }
}
