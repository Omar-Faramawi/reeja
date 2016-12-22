<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\PackageSelectRequest;
use Tamkeen\Ajeer\Models\Bundle;
use Tamkeen\Ajeer\Models\Invoice;
use Tamkeen\Ajeer\Models\InvoiceBundle;
use Tamkeen\Ajeer\Models\IshaarSetup;
use Tamkeen\Ajeer\Utilities\Constants;
use Tamkeen\Platform\Billing\Connectors\Connector;

class PackageSubscribeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paidbundles = Bundle::paid()->active()->get();
        $trialBundles = Bundle::trail()->firstOrFail();
        $ishaarSetup = IshaarSetup::taqawelPaid()->firstOrFail();
        $hasInvoiceBundles = InvoiceBundle::byMe()->where('bundle_id',1)->count();

        return view("front.packagesubscribe.index",
            compact("paidbundles", "trialBundles", "ishaarSetup", "hasInvoiceBundles"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function accept(PackageSelectRequest $packageSelectRequest)
    {
        $bundle = Bundle::where("min_of_num_ishaar", "<=", $packageSelectRequest->requestedIshaars)
            ->where("max_of_num_ishaar", ">=", $packageSelectRequest->requestedIshaars)
            ->paid()->active();

        if ($bundle->count() > 0) {
            $bundle = $bundle->firstOrFail();
            $msg['max_of_num_ishaar'] = $bundle->monthly_amount;
            $totalCount = ($packageSelectRequest->requestedIshaars * $bundle->monthly_amount);
            $msg['totalCount'] = $totalCount;

            return json_encode($msg);
        } else {
            return response()->json(['error' => trans('packagesubscribe.noBundle')], 422);
        }
    }

    public function approve(PackageSelectRequest $packageSelectRequest, Connector $connector)
    {
        if (empty($packageSelectRequest->requestedIshaars) || empty($packageSelectRequest->requestedIshaars)) {
            return response()->json(['error' => trans('packagesubscribe.noBundle')], 422);
        }
        $bundle = Bundle::where("min_of_num_ishaar", "<=", $packageSelectRequest->requestedIshaars)
            ->where("max_of_num_ishaar", ">=", $packageSelectRequest->requestedIshaars)
            ->paid()->active();

        if ($bundle->count() < 1) {
            return response()->json(['error' => trans('packagesubscribe.noBundle')], 422);
        }
        $bundle = $bundle->firstOrFail();
        $bundle_id = $bundle->id;

        $ishaar_setup = IshaarSetup::taqawelPaid()->firstOrFail();
        $amount = ($packageSelectRequest->requestedIshaars * $bundle->monthly_amount);
        $period = $ishaar_setup->paid_ishaar_payment_expiry_period;
        $bundlePeriod = $ishaar_setup->paid_ishaar_valid_expiry_period;
        $issueDate = Carbon::today()->format("Y-m-d");
        $periodtype = $ishaar_setup->paid_ishaar_payment_expiry_period_type;
        $bundleperiodtype = $ishaar_setup->paid_ishaar_valid_expiry_period_type;
        $invoiceExpiryDate = getDiffPeriodDay($issueDate, $period, $periodtype);
        $bundleExpiryDate = getDiffPeriodDay($issueDate, $bundlePeriod, $bundleperiodtype);
        $provider_id = getCurrentUserNameAndId()[0];

        // Start Making Invoice
        $accountNumber = getLoggedAccountNumber($connector);
        $items = [
            [
                'item_name'  => 'Notices Bundle',
                'item_count' => $packageSelectRequest->requestedIshaars,
                'item_price' => $bundle->monthly_amount,
            ],
        ];
        $createdBill = $connector->createBill($accountNumber, $amount, $items, $invoiceExpiryDate);
        //End Making Invoice

        //create Invoice
        $invoice = new Invoice;
        $invoice->bill_number = $createdBill['bill_number'];
        $invoice->amount = $amount;
        $invoice->account_no = $accountNumber;
        $invoice->provider_type = Auth::user()->user_type_id;
        $invoice->provider_id = $provider_id;
        $invoice->issue_date = $issueDate;
        $invoice->expiry_date = $invoiceExpiryDate;
        $invoice->status = Invoice::STATUS_PENDING;
        $invoice->invoice_type = Constants::INVOICE_TYPES['bundle'];
        $invoice->save();
        $open_invoice_bundles = InvoiceBundle::where('bundle_id', $bundle_id)->where('status',
            Invoice::STATUS_PENDING)
            ->where("invoice_id", $invoice->id)
            ->first();

        $invoiceBundles = new InvoiceBundle();
        $invoiceBundles->invoice_id = $invoice->id;
        $invoiceBundles->bundle_id = $bundle_id;
        $invoiceBundles->provider_type = Auth::user()->user_type_id;
        $invoiceBundles->provider_id = $provider_id;
        $invoiceBundles->num_of_notices = $packageSelectRequest->requestedIshaars;
        $invoiceBundles->num_remaining_notices = $packageSelectRequest->requestedIshaars;
        $invoiceBundles->status = Constants::INVOICE_STATUS['pending'];
        $invoiceBundles->expire_date = $bundleExpiryDate;
        $invoiceBundles->save();
    }


    public function activate()
    {
        $hasInvoiceBundles = InvoiceBundle::byMe()->count();
        if ($hasInvoiceBundles) {

            return response()->json(['error' => trans('packagesubscribe.trailNotAvailable')], 422);
        }

        $trialBundles = Bundle::trail()->firstOrFail();
        $ishaar_setup = IshaarSetup::taqawelPaid()->firstOrFail();
        $period = $ishaar_setup->paid_ishaar_valid_expiry_period;
        $issueDate = Carbon::today()->format("Y-m-d");
        $periodtype = $ishaar_setup->paid_ishaar_valid_expiry_period_type;
        $expiryDate = getDiffPeriodDay($issueDate, $period, $periodtype);
        $provider_id = getCurrentUserNameAndId()[0];

        $invoiceBundles = new InvoiceBundle();
        $invoiceBundles->bundle_id = $trialBundles->id;
        $invoiceBundles->provider_type = Auth::user()->user_type_id;
        $invoiceBundles->provider_id = $provider_id;
        $invoiceBundles->num_of_notices = $trialBundles->max_of_num_ishaar;
        $invoiceBundles->num_remaining_notices = $trialBundles->max_of_num_ishaar;
        $invoiceBundles->status = Invoice::STATUS_PAID;
        $invoiceBundles->expire_date = $expiryDate;
        $invoiceBundles->save();

        return trans("packagesubscribe.trailActivated");

    }

    public function invoice()
    {
        $invoice = InvoiceBundle::byMe()->get()->last();
        $ishaar_setup = IshaarSetup::taqawelPaid()->firstOrFail();

        return view("front.packagesubscribe.invoice", compact("invoice", 'ishaar_setup'));
    }

    /**
     * List user subscribed packages .
     *
     * @return \Illuminate\Http\Response
     */
    public function myPackages()
    {
        if (request()->ajax()) {
            $packages   = InvoiceBundle::byMe();
            $total_count = ($packages->count()) ? $packages->count() : 1;
            $columns     = request()->input('columns');

            return dynamicAjaxPaginate($packages, $columns, $total_count, []);
        }

        return view('front.packagesubscribe.my_packages');
    }

}