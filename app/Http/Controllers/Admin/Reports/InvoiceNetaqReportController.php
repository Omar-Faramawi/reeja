<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Establishment;
use Tamkeen\Ajeer\Utilities\Constants;

class InvoiceNetaqReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.establishment-netaq.index');
    }

    public function netaqChart($startDate = '', $endDate = '')
    {
        $establishments = Establishment::whereHas('invoice', function ($query) use ($startDate, $endDate) {
            $query->where('provider_type', Constants::USERTYPES['est']);
            $query->where('status', '1');

            if ($startDate <> '') {
                $query->where('paid_date', '>', $startDate);
                session(['startDate' => $startDate]);
            } else {
                session(['startDate' => '']);
            }
            if ($endDate <> '') {
                $query->where('paid_date', '<', $endDate);
                session(['endDate' => $endDate]);
            } else {
                session(['endDate' => '']);
            }
        })->groupBy('est_nitaq')->select('est_nitaq',
            DB::raw('count(*) as total'))->get();
        $returnedEstablishments = [];
        foreach ($establishments as $establishment) {
            $returnedEstablishments[] = [
                'statusName'  => $establishment->est_nitaq,
                'statusValue' => $establishment->total,
                'sourceField' => $establishment->est_nitaq
            ];
        }

        return $returnedEstablishments;
    }

    public function getEstablishmentByNetaq($netaq)
    {
        $establishments = Establishment::where('est_nitaq', $netaq)->whereHas('invoice', function ($query) {
            $query->where('provider_type', Constants::USERTYPES['est']);
            $query->where('status', '1');

            if (session('startDate') <> '') {
                $query->where('paid_date', '>', session('startDate'));
            }
            if (session('endDate')) {
                $query->where('paid_date', '<', session('endDate'));
            }
        })->get();
        $data = [];
        foreach ($establishments as $establishment) {
            $data[] = [
                $establishment->id,
                $establishment->name,
                $establishment->est_activity,
                $establishment->est_nitaq,
                $establishment->estSize->name,
            ];

        }
        $returned = ['data' => $data];

        return response()->json($returned);
    }
}
