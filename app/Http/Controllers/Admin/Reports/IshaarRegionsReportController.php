<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Utilities\Constants;

class IshaarRegionsReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.ishaar-regions-report.index');
    }

    public function ishaarRegionsReportChart($startDate = null, $endDate = null)
    {
    	session(['startDate' => $startDate]);
        session(['endDate' => $endDate]);

    	$data = DB::table('contract_employees')
    			  ->leftJoin('hr_pool', 'contract_employees.id_number', '=', 'hr_pool.id')
    			  ->leftJoin('regions', 'hr_pool.region_id', '=', 'regions.id')
    			  ->where('contract_employees.status', 'approved')
    			  ->selectRaw('regions.name, regions.id, COUNT(regions.name) as total');
              

        if(! empty($startDate) && ! empty($endDate)) {
            $data = $data->whereBetween('contract_employees.start_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                         ->orWhereBetween('contract_employees.end_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        }
    
        $data = $data->groupBy('regions.name')->get();

        $returnedData = [];
        foreach ($data as $item) {
            $returnedData[] = [
                'statusName'  => $item->name,
                'statusValue' => $item->total,
                'sourceField' => $item->id
            ];
        }

        return $returnedData;
    }

    public function getIshaarByRegion($region)
    {
    	$startDate = session('startDate');
    	$endDate = session('endDate');

    	$ishaars = ContractEmployee::whereHas('hrPool', function($query) use ($region){
    		$query->whereHas('region', function($query) use ($region){
    			$query->where('id', $region);
    		});
    	})->with('contract')->with('hrPool.region');

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
               	$ishaar->hrPool->region->name
            ];

        }
        $returned = ['data' => $data];

        return response()->json($returned);
    }
}
