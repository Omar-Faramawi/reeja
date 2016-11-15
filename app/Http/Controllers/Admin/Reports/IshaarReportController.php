<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Utilities\Constants;

class IshaarReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.ishaar-report.index');
    }

    public function ishaarReportChart($type = 'provider_type', $startDate = null, $endDate = null)
    {
        session(['startDate' => $startDate]);
        session(['endDate' => $endDate]);

        $data = DB::table('contract_employees')
                  ->leftJoin('contracts', 'contract_employees.contract_id', '=', 'contracts.id')
                  ->where('contract_employees.status', 'approved')
                  ->selectRaw('contracts.'.$type.', COUNT(contracts.'.$type.') as total');
              

        if(! empty($startDate) && ! empty($endDate)) {
            $data = $data->whereBetween('contract_employees.start_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                         ->orWhereBetween('contract_employees.end_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        }
    
        $data = $data->groupBy('contracts.'.$type)->get();

        $returnedData = [];
        foreach ($data as $item) {
            $returnedData[] = [
                'statusName'  => ($type == 'benf_type' ? Constants::userTypes($item->benf_type) : Constants::userTypes($item->provider_type)),
                'statusValue' => $item->total,
                'sourceField' => ($type == 'benf_type' ? $item->benf_type : $item->provider_type)
            ];
        }

        return $returnedData;
    }

    public function getIshaarByUserType($type, $user_type)
    {
        $startDate = session('startDate');
        $endDate = session('endDate');

        switch ($type) {
            case 'provider_type':
                $ishaars = ContractEmployee::where('status', 'approved')->with('contract')->whereHas('contract' , function($query) use ($user_type){
                    $query->where('provider_type', $user_type);
                });
                if(! empty($startDate) && ! empty($endDate)) {
                    $ishaars = $ishaars->whereBetween('start_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                                 ->orWhereBetween('end_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
                }

                $ishaars = $ishaars->get();
                break;
            
            case 'benf_type':
                 $ishaars = ContractEmployee::where('status', 'approved')->with('contract')->whereHas('contract' , function($query) use ($user_type){
                    $query->where('benf_type', $user_type);
                });
                 if(! empty($startDate) && ! empty($endDate)) {
                    $ishaars = $ishaars->whereBetween('start_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                                 ->orWhereBetween('end_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
                }

                $ishaars = $ishaars->get();
                break;
        }
        $data = [];
        foreach ($ishaars as $ishaar) {
            $data[] = [
                $ishaar->id,
                ($type == 'benf_type' ? $ishaar->contract->benf_name : $ishaar->contract->providername),
                ($type == 'benf_type' ? Constants::userTypes($ishaar->contract->benf_type) : Constants::userTypes($ishaar->contract->provider_type)),
                ($type == 'benf_type' ? trans('reports.benf_name') : trans('reports.provider_name')),
                trans('labels.ishaar').' '.Constants::contractTypes()[$ishaar->contract->contract_type_id]
            ];

        }
        $returned = ['data' => $data];

        return response()->json($returned);
    }
}
