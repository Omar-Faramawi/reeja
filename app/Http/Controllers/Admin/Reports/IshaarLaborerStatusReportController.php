<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Individual;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Utilities\Constants;

class IshaarLaborerStatusReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.ishhar-laborer-status-report.index');
    }

    public function ishaarLaborerStatusReportChart($startDate = null, $endDate = null)
    {
        
        session(['startDate' => $startDate]);
        session(['endDate' => $endDate]);
        

        $returnedData = [];

        $returnedData[] = [
            'statusName'  => trans('reports.laborer-status.saudi'),
            'statusValue' => $this->getIshaarsBySaudi($startDate, $endDate)->count(),
            'sourceField' => 'saudi'
        ];
        $returnedData[] = [
            'statusName'  => trans('reports.laborer-status.visitor'),
            'statusValue' => $this->getIshaarsByVisitors($startDate, $endDate)->count(),
            'sourceField' => 'visitor'
        ];
        $returnedData[] = [
            'statusName'  => trans('reports.laborer-status.follower'),
            'statusValue' => $this->getIshaarsByFollowers($startDate, $endDate)->count(),
            'sourceField' => 'follower'
        ];
        $returnedData[] = [
            'statusName'  => trans('reports.laborer-status.resident'),
            'statusValue' => $this->getIshaarsByResidents($startDate, $endDate)->count(),
            'sourceField' => 'resident'
        ];

        return $returnedData;
    }

    public function getIshaarByStatus($status)
    {
        switch ($status) {
            case 'saudi':
                $ishaars = $this->getIshaarsBySaudi(session('startDate'), session('endDate'));
                break;
            case 'visitor':
                $ishaars = $this->getIshaarsByVisitors(session('startDate'), session('endDate'));
            break;
            case 'follower':
                $ishaars = $this->getIshaarsByFollowers(session('startDate'), session('endDate'));
                break;
            case 'resident':
                $ishaars = $this->getIshaarsByResidents(session('startDate'), session('endDate'));
            break;
        }
    	
        $data = [];
        foreach ($ishaars as $ishaar) {
            $data[] = [
                $ishaar->hrPool->contractEmployee->id,
               	$ishaar->hrPool->contractEmployee->contract->providername,
               	$ishaar->hrPool->contractEmployee->contract->benf_name,
               	trans('reports.laborer-status.'.$status)
            ];

        }
        $returned = ['data' => $data];

        return response()->json($returned);
    }

    protected function getIshaarsBySaudi($startDate = null, $endDate = null)
    {
        return Individual::whereHas('hrPool', function($query) use ($startDate, $endDate){
            if(! empty($startDate) && ! empty($endDate)) {
                $query->whereHas('contractEmployee', function($q) use ($startDate, $endDate){
                        $q->whereBetween('start_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                          ->orWhereBetween('.end_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
                });
            }else{
                $query->has('contractEmployee');
            }
        })->where('nid', 'LIKE', '1%')->with('hrPool.contractEmployee.contract')->get();
    }

    protected function getIshaarsByVisitors($startDate=null, $endDate=null)
    {
        return Individual::whereHas('hrPool', function($query) use ($startDate, $endDate){
            if(! empty($startDate) && ! empty($endDate)) {
                $query->whereHas('contractEmployee', function($q) use ($startDate, $endDate){
                        $q->whereBetween('start_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                          ->orWhereBetween('.end_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
                });
            }else{
                $query->has('contractEmployee');
            }
        })->where('nid', 'LIKE', '4%')->with('hrPool.contractEmployee.contract')->get();
    }

    protected function getIshaarsByFollowers($startDate=null, $endDate=null)
    {
        return Individual::whereHas('hrPool', function($query) use ($startDate, $endDate){
             if(! empty($startDate) && ! empty($endDate)) {
                $query->whereHas('contractEmployee', function($q) use ($startDate, $endDate){
                        $q->whereBetween('start_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                          ->orWhereBetween('.end_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
                });
            }else{
                $query->has('contractEmployee');
            }
        })->where('nid', 'LIKE', '2%')->where('ownership_id', 'LIKE', '2%')->with('hrPool.contractEmployee.contract')->get();
    }

    protected function getIshaarsByResidents($startDate=null, $endDate=null)
    {
        return Individual::whereHas('hrPool', function($query) use ($startDate, $endDate){
            if(! empty($startDate) && ! empty($endDate)) {
                $query->whereHas('contractEmployee', function($q) use ($startDate, $endDate){
                        $q->whereBetween('start_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                          ->orWhereBetween('.end_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
                });
            }else{
                $query->has('contractEmployee');
            }
        })->where('nid', 'LIKE', '2%')->where(function($query){
            $query->where('ownership_id', 'NOT LIKE', '2%')
                  ->orWhereNull('ownership_id');
        })->with('hrPool.contractEmployee.contract')->get();
    }
}
