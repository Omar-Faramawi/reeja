<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Carbon\Carbon;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Utilities\Constants;

class ContractsBundleReportsController extends Controller
{

    public function index()
    {
        return view('admin.reports.contract-bundles.index');
    }

    public function chartData($startDate = null, $endDate = null)
    {
        $contracts = Contract::join('contract_employees', 'contracts.id', '=', 'contract_employees.contract_id')
            ->join('invoice_bundles', 'invoice_bundles.id', '=', 'contract_employees.bundle_id')
            ->join('bundles', 'invoice_bundles.bundle_id', '=', 'bundles.id')
            ->select('*',
                'bundles.min_of_num_ishaar as bundle_min',
                'bundles.max_of_num_ishaar as bundle_max',
                \DB::raw('count(*) as contract_count'));

        if (!empty($startDate) && !empty($endDate)) {
            $contracts = $contracts->whereBetween('contracts.created_at',
                [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        }

        $contracts = $contracts->groupBy('bundles.max_of_num_ishaar')->get();

        $returnedContract = [];
        foreach ($contracts as $contract) {
            $returnedContract[] = [
                'bundleName' => '('.$contract->bundle_min.'-'.$contract->bundle_max.')',
                'bundleValue' => $contract->contract_count,
                'sourceField' => $contract->bundle_max
            ];
        }

        return $returnedContract;
    }

    public function contractByBundle($contractBundle)
    {
        $contracts = Contract::join('contract_employees', 'contracts.id', '=', 'contract_employees.contract_id')
            ->join('invoice_bundles', 'invoice_bundles.id', '=', 'contract_employees.bundle_id')
            ->join('bundles', 'invoice_bundles.bundle_id', '=', 'bundles.id')
            ->select('*', 'contract_employees.id as number',
                'contracts.status as contract_status',
                'bundles.min_of_num_ishaar as bundle_min',
                'bundles.max_of_num_ishaar as bundle_max'
            )
            ->where('bundles.max_of_num_ishaar', '=', $contractBundle)
            ->get();

        $data = [];
        foreach ($contracts as $contract) {
            $data[] = [
                @$contract->number,
                @$contract->providername,
                @$contract->benf_name,
                @$contract->bundle_min.' - '.@$contract->bundle_max,
                Constants::contract_statuses(@$contract->contract_status)
            ];
        }
        $returned = ['data' => $data];

        return response()->json($returned);
    }
}