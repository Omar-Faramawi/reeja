<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Reports;

use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Establishment;

class NitaqEstablishmentsReportsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $establishments = Establishment::whereColumn('est_nitaq', '!=', 'est_nitaq_old')->paginate(10);

        return view('admin.reports.establishment-netaq.view', compact('establishments'));
    }
}