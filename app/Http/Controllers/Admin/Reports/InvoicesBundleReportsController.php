<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Carbon\Carbon;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Utilities\Constants;

class InvoicesBundleReportsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.reports.invoices-bundles.index');
    }

    /**
     * @param null $startDate
     * @param null $endDate
     *
     * @return array
     */
    public function chartData($startDate = null, $endDate = null)
    {

        $contracts = Contract::join('contract_employees', 'contracts.id', '=', 'contract_employees.contract_id')
                             ->join('invoice_bundles', 'invoice_bundles.id', '=', 'contract_employees.bundle_id')
                             ->join('bundles', 'invoice_bundles.bundle_id', '=', 'bundles.id')
                             ->select('*', 'invoice_bundles.status as invoice_status',
                                 \DB::raw('count(*) as contracts_count'));

        if ( ! empty($startDate) && ! empty($endDate)) {
            $contracts = $contracts->whereBetween('contracts.created_at',
                [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        }

        $contracts = $contracts->groupBy('invoice_bundles.status')->get();

        $returnedContract = [];
        foreach ($contracts as $contract) {
            $returnedContract[] = [
                'bundleName'  => Constants::invoiceStatues($contract->invoice_status),
                'bundleValue' => $contract->contracts_count,
                'sourceField' => $contract->invoice_status,
            ];
        }

        return $returnedContract;

    }

    /**
     * @param $contractBundle
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function contractByBundle($contractBundle)
    {

        $contracts = Contract::join('contract_employees', 'contracts.id', '=', 'contract_employees.contract_id')
                             ->join('invoice_bundles', 'invoice_bundles.id', '=', 'contract_employees.bundle_id')
                             ->join('bundles', 'invoice_bundles.bundle_id', '=', 'bundles.id')
                             ->where('invoice_bundles.status', '=', $contractBundle)
                             ->select('*',
                                 'invoice_bundles.status as invoice_status',
                                 'contract_employees.id as number',
                                 'contracts.status as contract_status',
                                 'bundles.min_of_num_ishaar as bundle_min',
                                 'bundles.max_of_num_ishaar as bundle_max'
                             )
                             ->get();

        $data = [];

        foreach ($contracts as $contract) {
            $data[] = [
                @$contract->number,
                @$contract->providername,
                @$contract->benf_name,
                @$contract->bundle_min . ' - ' . @$contract->bundle_max,
                Constants::invoiceStatues(@$contract->invoice_status),
            ];
        }
        $returned = ['data' => $data];

        return response()->json($returned);
    }

}