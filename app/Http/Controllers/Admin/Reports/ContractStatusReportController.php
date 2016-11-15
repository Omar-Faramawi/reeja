<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Utilities\Constants;

class ContractStatusReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.contract-status.index');
    }

    public function contractStatusChart($startDate = '', $endDate = '')
    {
        $contracts = new Contract();
        if ($startDate <> '') {
            $contracts = $contracts->where('created_at', '>', $startDate);
            session(['startDate' => $startDate]);
        } else {
            session(['startDate' => '']);
        }
        if ($endDate <> '') {
            $contracts = $contracts->where('created_at', '<', $endDate);
            session(['endDate' => $endDate]);
        } else {
            session(['endDate' => '']);
        }
        $contacts = $contracts->whereIn('contract_type_id', [1, 3, 4])->groupBy('status')->select('status',
            DB::raw('count(*) as total'))->get();

        $returnedContract = [];
        foreach ($contacts as $contact) {
            $returnedContract[] = [
                'statusName'  => Constants::contract_statuses($contact->status),
                'statusValue' => $contact->total,
                'sourceField' => $contact->status
            ];
        }

        return $returnedContract;
    }

    public function getContractByStatus($contract_status)
    {
        $contracts = new Contract();
        if (session('startDate') <> '') {
            $contracts = $contracts->where('created_at', '>', session('startDate'));
        }
        if (session('endDate') <> '') {
            $contracts = $contracts->where('created_at', '<', session('endDate'));
        }
        $contracts = $contracts->whereIn('contract_type_id', [1, 3, 4])->where('status', $contract_status)->get();
        $data = [];
        foreach ($contracts as $contract) {
            $data[] = [
                $contract->id,
                $contract->providername,
                $contract->benf_name,
                Constants::contractTypes($contract->contract_type_id),
                Constants::contract_statuses($contract->status)
            ];

        }
        $returned = ['data' => $data];

        return response()->json($returned);
    }
}
