<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Invoice;
use Tamkeen\Ajeer\Models\ContractCertificate;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\BaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    /**
     * List Invoices .
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $invoices   = Invoice::byMe();
            $total_count = ($invoices->count()) ? $invoices->count() : 1;
            $columns     = request()->input('columns');
            
            if (request()->input('bill_number')) {
                $invoices = $invoices->where('bill_number',request()->input('bill_number'));
            }
            if (request()->input('amount')) {
                $invoices = $invoices->where('amount', request()->input('amount'));
            }
            if (request()->input('description')) {
                $invoices = $invoices->where('description', 'LIKE', '%' . request()->input('description') . '%');
            }
            if (request()->input('issue_date')) {
                $invoices = $invoices->where('issue_date', request()->input('issue_date'));
            }
            if (request()->input('expiry_date')) {
                $invoices = $invoices->where('expiry_date', request()->input('expiry_date'));
            }
            if (request()->input('status')) {
                $invoices = $invoices->where('status', request()->input('status'));
            }
            if (request()->input('invoice_type')) {
                $invoices = $invoices->where('invoice_type', request()->input('invoice_type'));
            }
            
            $buttons   = [
                'view' => ["css_class" => "blue"],
            ];

            return dynamicAjaxPaginate($invoices, $columns, $total_count, $buttons);
        }

        return view('front.invoices.index');
    }

    /**
     * Show Only One Vacancy.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::byMe()->with('contract','certificates','certificates.contract')->findOrFail($id);
        
        return view('front.invoices.show', compact('invoice'));
    }

    
}
