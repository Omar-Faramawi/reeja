<?php

namespace Tamkeen\Ajeer\Http\Controllers\front;

use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\Contract;
use Tamkeen\Ajeer\Models\ContractEmployee;
use Tamkeen\Ajeer\Models\Experience;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Models\Nationality;
use Tamkeen\Ajeer\Models\Invoice;
use Tamkeen\Ajeer\Models\IshaarSetup;
use Tamkeen\Ajeer\Models\Reason;
use Tamkeen\Ajeer\Http\Requests\CancelIshaarRequest;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\InvoiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tamkeen\Ajeer\Utilities\Constants;
use Illuminate\Support\Facades\Route;
use Tamkeen\Platform\Billing\Connectors\Connector;
use Carbon\Carbon;

class NoticesController extends Controller
{

    /**
     * Show Ishaar Layout.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        $can_generate_ishaar = Constants::SERVICETYPES['provider'];
        if (strpos(Route::getCurrentRoute()->uri(),'direct_ishaar') !== false){
                $url = '/direct_ishaar';
                $can_generate_ishaar = Constants::SERVICETYPES['benf'];
                if(auth()->user()->user_type_id == Constants::USERTYPES['job_seeker']){
                    session()->replace(['service_type' => Constants::SERVICETYPES['provider']]);
                }elseif (!in_array(auth()->user()->user_type_id, [Constants::USERTYPES['saudi'],Constants::USERTYPES['job_seeker']])){
                    session()->replace(['service_type' => Constants::SERVICETYPES['benf']]);
                }

        }else $url = '/ishaar';

        // Get the current service type id ( provider or benf )
        // check if we got the right one before continue
        if ($id) {
            if (in_array($id, Constants::SERVICETYPES)) {
                session()->replace(['service_type' => $id]);    // save to session
            }
        }
        if (request()->ajax()) {
            $columns = request()->input('columns');
            $ishaars = ContractEmployee::whereHas('contract',
                    function ($cont_q, $id = null) {
                  if (strpos(Route::getCurrentRoute()->uri(),'direct_ishaar') !== false){
                        $cont_q->byMe()->approved()->directEmployee();
                        if ($id) {
                            if($id === Constants::SERVICETYPES['benf']) {
                                $cont_q->toMe()->approved()->directEmployee();
                            }
                        }
                        if(session()->get('service_type') === Constants::SERVICETYPES['benf']) {
                            $cont_q->toMe()->approved()->directEmployee();
                        }
                         } else {
                        $cont_q->byMe()->approved()->hireLabor();
                        if ($id) {
                            if($id === Constants::SERVICETYPES['benf']) {
                                $cont_q->toMe()->approved()->hireLabor();
                            }
                        }
                        if(session()->get('service_type') === Constants::SERVICETYPES['benf']) {
                            $cont_q->toMe()->approved()->hireLabor();
                        }
                    }

                }
                )->with(['hrPool.job', 'contract', 'contract.contractLocations']);



            $total_count = $ishaars->count() ? $ishaars->count() : 1;
            $buttons = [
                'view' => [
                    "text" => trans("ishaar_setup.actions.details"),
                    "url" => url($url),
                    "uri" => "show_ishaar",
                    "css_class" => "green",
                ],
                'cancel' => [
                    "text" => trans("ishaar_setup.actions.cancel"),
                    "url" => url($url),
                    "uri" => "show_ishaar",
                    "css_class" => "red askcancelishaar",
                ],
                'print' => [
                    "text" => trans("ishaar_setup.actions.print"),
                    "url" => url($url),
                    "uri" => "show_ishaar?print=1",
                    "css_class" => "blue",
                ]
            ];


            return dynamicAjaxPaginate($ishaars, $columns, $total_count,
                $buttons);
        }
        if (Route::getCurrentRoute()->getPath() == 'direct_ishaar'){
            $contracts = Contract::toMe()->approved()->directEmployee()->get();
        }else{
            $contracts = Contract::byMe()->approved()->hireLabor()->get();

        }

        return view('front.ishaar.index', compact('contracts', 'url', 'can_generate_ishaar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('front.ishaar.create');
    }

    /**
     * generate a newly invoice in storage.
     *
     * @return Response
     */
    public function generateInvoice($id, Connector $connector)
    {
        $contract_id = $id;
        if (Route::getCurrentRoute()->getcompiled()->getstaticPrefix() == '/direct_ishaar')
            $invoice_type=Constants::INVOICE_TYPES['contract_direct_employee'];
        else
            $invoice_type=Constants::INVOICE_TYPES['contract_hire_labor'];
       
        // Check if the user can make new invoice or not
        $open_invoice = Invoice::where('contracts_id', $contract_id)->where('status',Invoice::STATUS_PENDING)->first();
        if (!empty($open_invoice)) {
            return response()->json(['error' => trans('ishaar_setup.cant_add_invoice')], 422);
        }
        $contract = Contract::findOrFail($id);
        if($contract){
        $benef_name = $contract->benf_name;
        $ishaar_setup = IshaarSetup::where('ishaar_type_id',$contract->contract_type_id)->first();
        if($contract->contractEmployee->count()) {
                $amount = ($ishaar_setup->amount) * ($contract->contractEmployee->count());
                $days = $ishaar_setup->payment_period;
                $issueDate = Carbon::now()->toDateTimeString();
                $expiryDate = Carbon::now()->addDays($days);
                $accountNumber = getLoggedAccountNumber($connector);
                $items = [
                    [
                        'item_name' => trans('ishaar_setup.headings.create'),
                        'item_count' => 1,
                        'item_price' => $amount,
                    ],
                ];
                $createdBill = $connector->createBill($accountNumber, $amount,
                    $items, $expiryDate);
                //create Invoice
                $invoice = new Invoice;
                $invoice->contracts_id = $contract_id;
                $invoice->amount = $amount;
                $invoice->account_no = $accountNumber;
                $invoice->benf_name = $benef_name;
                $invoice->issue_date = $issueDate;
                $invoice->expiry_date = $expiryDate;
                $invoice->description = trans('ishaar_setup.headings.create');
                $invoice->status = Constants::INVOICE_STATUS['pending'];
                $invoice->provider_type = Auth::user()->user_type_id;
                $invoice->provider_id = getCurrentUserNameAndId()[0];
                $invoice->invoice_type = $invoice_type;
                $invoice->save();
                foreach ($contract->contractEmployee as $ce) {
                    $notice = ContractEmployee::findOrFail($ce->id);
                    $notice->invoices_id = $invoice->id;
                    $notice->save();
                }
                return response()->json(trans('ishaar_setup.add_invoice_success',
                            ['number' => $invoice->id, 'contract' => $id, 'amount' => $amount]));
            } else{
            return response()->json(['error' => trans('ishaar_setup.no_contractEmployee')], 422);

        }
        }else{
            return response()->json(['error' => trans('ishaar_setup.no_contract')], 422);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if(Route::getCurrentRoute()->getcompiled()->getstaticPrefix()== '/direct_ishaar')
            $contract = Contract::toMe()->directEmployee()->approved()->findOrFail($id);
        else
            $contract = Contract::byMe()->hireLabor()->approved()->findOrFail($id);


        return view('front.ishaar.create', compact('contract'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function showIshaar($id)
    {

        if (session()->get('service_type') === Constants::SERVICETYPES['benf']) {
            $contract = ContractEmployee::whereHas('contract', function ($cont_q) {
                    if(Route::getCurrentRoute()->getcompiled()->getstaticPrefix()== '/direct_ishaar')
                        $cont_q->toMe()->approved()->directEmployee();
                    else
                        $cont_q->toMe()->approved()->hireLabor();

                })->findOrFail($id);
        } else{
            $contract = ContractEmployee::whereHas('contract', function ($cont_q) {
                if(Route::getCurrentRoute()->getcompiled()->getstaticPrefix()== '/direct_ishaar')
                        $cont_q->byMe()->approved()->directEmployee();
                    else
                        $cont_q->byMe()->approved()->hireLabor();
            })->findOrFail($id);
        }

        $reasons  = Reason::where('parent_id',6)->get();

        return view('front.ishaar.show', compact('contract','reasons'));
    }

    /**
     * change the status of specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function askCancelIshaar(CancelIshaarRequest $request)
    {
        $auth = ContractEmployee::has_permission_cancelIshaar($request->id_r);
        $ishaar = ContractEmployee::findOrFail($request->id_r);
        if (!in_array($ishaar->status,['cancelled', 'provider_cancel', 'benef_cancel'])) {
        if ($auth == '1') {
            if(session()->get('service_type') === Constants::SERVICETYPES['provider'])
            $status = 'provider_cancel';
            else
            $status = 'benef_cancel';

            $msg = trans('ishaar_setup.ask_cancel_ishaar_success');

        }else {
            $status = 'cancelled';
            $msg = trans('ishaar_setup.cancelIshaar_success');
        }
                if ($request->reason != 'other') {
                    $ishaar->status = $status;
                    $ishaar->reasons_id = $request->reason;
                    $ishaar->rejection_reason = $request->details;
                    $ishaar->save();
                    return $msg;
                } else {
                    if (!$request->other) {
                        throw new Exception;
                    } else {
                        $ishaar->status = $status;
                        $ishaar->rejection_reason = $request->details;
                        $ishaar->other_reasons = $request->other;
                        $ishaar->save();
                        return $msg;
                    }
                }


        } else {
                return response()->json(['error' => trans('ishaar_setup.cancelIshaar_refused')],
                        422);
            }

            return abort(401);
    }
}