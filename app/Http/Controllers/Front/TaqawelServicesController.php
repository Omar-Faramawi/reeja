<?php

namespace Tamkeen\Ajeer\Http\Controllers\front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\TaqawelSendOfferRequest;
use Tamkeen\Ajeer\Http\Requests\TaqawelServicesRequest;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Models\ContractLocation;
use Tamkeen\Ajeer\Models\InvoiceBundle;
use Tamkeen\Ajeer\Models\MarketTaqawoulServices;
use Tamkeen\Ajeer\Models\ContractNature;
use Tamkeen\Ajeer\Models\BaseModel;
use Tamkeen\Ajeer\Models\Reason;
use Tamkeen\Ajeer\Models\Region;
use Tamkeen\Ajeer\Utilities\Constants;
use Tamkeen\Ajeer\Models\Contract;

class TaqawelServicesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $columns = request()->input('columns');
            $services = MarketTaqawoulServices::byMe()->byBenf()->with('contractNature');

            if (request()->input('service_id')) {
                $services = $services->whereHas('contractNature', function ($nature_id) {
                    $nature_id->where('name', 'LIKE', '%' . request()->input('service_id') . '%');
                });
            }
            if (request()->input('description')) {
                $services = $services->where('description', 'LIKE', '%' . request()->input('description') . '%');
            }

            $total_count = $services->count() ? $services->count() : 1;

            $buttons = [
                'edit'   => [
                    "text"        => trans("taqawoul.buttons.edit"),
                    "url"         => url("/taqawel/taqawelService"),
                    "uri"         => "edit",
                    "css_class"   => "blue",
                    'taqawelServiceEdit' => true,

                ],
                'delete' => [
                    "text"          => trans("taqawoul.buttons.delete"),
                    "url"           => url("/taqawel/taqawelService"),
                    "uri"           => "delete",
                    "css_class"     => "red delete_taqawel_service",
                    'taqawelServiceDelete' => true,

                ],
            ];

            return dynamicAjaxPaginate($services, $columns, $total_count, $buttons);
        }
        $can_add = BaseModel::estCanBeBenf();

        return view("front.taqawel.taqawel_services.index", compact('services', 'can_add'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (BaseModel::estCanBeBenf()) {
            $service_types = ContractNature::active()->get()->pluck("name", "id");
            $service_types["other"] = trans("taqawoul.form_attributes.other");

            $cached_data = [
                'contract_nature_id' => null,
                'new_service' => null,
                'description' => null
            ];

            if (session()->get('selected_establishment')) {
                $id = session()->get('selected_establishment.id');
            } elseif (session()->get('government')) {
                $id = session()->get('government.id');
            } else {
                $id = auth()->user()->id_no;
            }
            if (Cache::has('taqawel_service.' . $id)) {
                $cached_data = Cache::pull('taqawel_service.' . $id);
            }

            return view("front.taqawel.taqawel_services.create",
                compact('service_types', 'cached_data'));
        } else {
            return abort(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request|TaqawelServicesRequest $request
     *
     * @return \Illuminate\Http\Response
     */

    public function store(TaqawelServicesRequest $request)
    {
        if (BaseModel::estCanBeBenf()) {
            $data = $request->only(['contract_nature_id', 'new_service', 'description']);

            if ($request->get('save_action') == 'draft') {
                if (session()->get('selected_establishment')) {
                    $id = session()->get('selected_establishment.id');
                } elseif (session()->get('government')) {
                    $id = session()->get('government.id');
                } else {
                    $id = auth()->user()->id_no;
                }

                Cache::put('taqawel_service.'.$id, $data, 7200);
                return trans('taqawoul.success_data');
            }

            if (!empty($data['new_service'])) {
                $new_nature = ContractNature::create(['name' => $request->new_service, 'status' => 0]);
                $data['contract_nature_id'] = $new_nature->id;
                unset($data['new_service']);
            } else {
                unset($data['new_service']);
            }
            $data['provider_or_benf'] = Constants::SERVICETYPES['benf'];
            $data['service_prvdr_benf_id'] = \Auth::user()->user_type_id;
            $current = new BaseModel;
            $data['service_id'] = $current->getCurrentLoginId();
            $save = MarketTaqawoulServices::create($data);

            return trans('taqawoul.success_data');
        } else {
            return abort(401);
        }
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
        $service = MarketTaqawoulServices::byBenf()->with('contractNature')->findOrFail($id);
        $service_types = ContractNature::active()->get()->pluck("name", "id");
        if (!isset($service_types[$service->contract_nature_id])) {
            $service_types[$service->contract_nature_id] = $service->contractNature->name;
        }
        $service_types["other"] = trans("taqawoul.form_attributes.other");

        $cached_data = [
            'contract_nature_id' => $service->contract_nature_id,
            'new_service' => null,
            'description' => $service->description
        ];

        return view("front.taqawel.taqawel_services.create", compact('service', 'service_types', 'cached_data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */

    public function update(TaqawelServicesRequest $request, $id)
    {
        $data = $request->only(array_keys($request->rules()));
        if (!empty($data['new_service'])) {
            $new_nature = ContractNature::create(['name' => $request->new_service, 'status' => 0]);
            $data['contract_nature_id'] = $new_nature->id;
            unset($data['new_service']);
        } else {
            unset($data['new_service']);
        }
        $update = MarketTaqawoulServices::findOrFail($id)->update($data);

        return trans('taqawoul.success_update');

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
        $delete = MarketTaqawoulServices::findOrFail($id)->delete();
        if ($delete) {
            return trans('taqawoul.success_delete');
        } else {
            return response()->json(['error' => trans('labels.not_authorized')], 422);
        }

    }

    /**
     * Display a listing of the Market Services.
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function listMarketServices($id = '')
    {

        if ($id) {
            if (in_array($id, Constants::SERVICETYPES)) {
                session()->replace(['service_type' => $id]);    // save to session
            }
        } elseif (session()->get('service_type')) {
            $id = session()->get('service_type');
        } else {
            $id = Constants::SERVICETYPES['provider'];
            session()->replace(['service_type' => $id]);
        }

        if ($id !== Constants::SERVICETYPES['benf']) {
            return $this->taqawelOfferContract($id);
        }

        $columns = request()->input('columns');

        if (request()->ajax()) {
            $data = MarketTaqawoulServices::byProviders()->byOthers()->providerHasPermission()->benfHasActivities()->active()->with('contractNature');

            if (request()->input('provider_name')) {
                $data = $data->where(function ($provider_q) {
                    $provider_q->whereHas('establishment', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('provider_name') . '%');
                    });
                    $provider_q->orWhereHas('individual', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('provider_name') . '%');
                    });
                    $provider_q->orWhereHas('government', function ($est_q) {
                        $est_q->where('name', 'LIKE', '%' . request()->input('provider_name') . '%');
                    });

                });
            }
            if (request()->input('service_type')) {
                $data = $data->where(function ($service_q) {
                    $service_q->whereHas("contractNature", function ($nature_q) {
                        $nature_q->where("name", 'LIKE', '%' . request()->input('service_type') . '%');
                    });

                });
            }
            if (request()->input('responsible_email')) {
                $data = $data->where(function ($responsible_q) {
                    $responsible_q->whereHas('establishment', function ($est_q) {
                        $est_q->whereHas("responsibles", function ($estr_q) {
                            $estr_q->where('responsible_email', 'LIKE', '%' . request()->input('responsible_email') . '%');
                        });
                    });
                    $responsible_q->orWhereHas('individual', function ($est_q) {
                        $est_q->where('email', 'LIKE', '%' . request()->input('responsible_email') . '%');
                    });
                    $responsible_q->orWhereHas('government', function ($est_q) {
                        $est_q->where('email', 'LIKE', '%' . request()->input('responsible_email') . '%');
                    });
                });
            }
            if (request()->input('phone')) {
                $data = $data->where(function ($responsible_q) {
                    $responsible_q->whereHas('establishment', function ($est_q) {
                        $est_q->whereHas("responsibles", function ($estr_q) {
                            $estr_q->where('responsible_phone', request()->input('phone'));
                        });
                    });
                    $responsible_q->orWhereHas('individual', function ($est_q) {
                        $est_q->where('phone', request()->input('phone'));
                    });
                });
            }
            if (request()->input('description')) {
                $data = $data->where('description', 'LIKE', '%' . request()->input('description') . '%');
            }

            $buttons = [
                'service_details' => [
                    'service_flag' => true,
                    'css_class'    => 'blue',
                    "text"         => trans("temp_job.ask_offer"),
                ],
            ];

            $total_count = ($data->count()) ? $data->count() : 1;

            return dynamicAjaxPaginate($data, $columns, $total_count, $buttons);
        }

        return view('front.taqawel.market.index');
    }


    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function taqawelOfferContract($id = '')
    {
        if ($id) {
            if (in_array($id, Constants::SERVICETYPES)) {
                session()->replace(['service_type' => $id]);    // save to session
            }
        } elseif (session()->get('service_type')) {
            $id = session()->get('service_type');
        } else {
            $id = Constants::SERVICETYPES['provider'];
            session()->replace(['service_type' => $id]);
        }

        if (request()->ajax()) {

            $query = MarketTaqawoulServices::byBenf()->byOthers()->benfHasPermission()->providerHasActivities()->with('contractNature');
            $columns = request()->input('columns');

            if ($name = request()->input("name")) {
                $query->where(function ($q) use ($name) {
                    $q->whereHas('individual', function ($q) use ($name) {
                        $q->where('name', 'LIKE', '%' . $name . '%');
                    });
                    $q->orWhereHas('establishment', function ($q) use ($name) {
                        $q->where('name', 'LIKE', '%' . $name . '%');
                    });
                    $q->orWhereHas('government', function ($q) use ($name) {
                        $q->where('name', 'LIKE', '%' . $name . '%');
                    });
                });
            }

            if ($contractNatureName = request()->input("contract_nature_name")) {
                $query->whereHas('contractNature', function ($q) use ($contractNatureName) {
                    $q->where('name', 'LIKE', '%' . $contractNatureName . '%');
                });
            }

            $total_count = $query->count() ? $query->count() : 1;

            $buttons = [
                'show' => [
                    "text"      => trans("temp_job.show_offer"),
                    "url"       => url(request()->segment(1) . "/offer-taqawel-contract"),
                    "col"       => "id",
                    "uri"       => "show",
                    "css_class" => "blue",
                ],
            ];

            return dynamicAjaxPaginate($query, $columns, $total_count, $buttons);
        }

        return view('front.labor_market.tqawel.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function askTaqawelOffer(Request $request)
    {

        $service = MarketTaqawoulServices::where('id', $request->id)->with('contractNature')->firstOrFail();

        $contract = new Contract();
        $contract->contract_type_id = \Tamkeen\Ajeer\Utilities\Constants::CONTRACTTYPES['taqawel'];
        $contract->provider_type = $service->service_prvdr_benf_id;
        $contract->provider_id = $service->service_id;
        $contract->benf_type = \Auth::user()->user_type_id;
        $contract->benf_id = $service->getCurrentLoginId();
        $contract->contract_nature_id = $service->contractNature->id;
        $contract->status = \Tamkeen\Ajeer\Utilities\Constants::CONTRACT_STATUSES['requested'];
        $contract->market_taqaual_services_id = $request->id;

        if ($contract->save()) {
            return trans('taqawel_market.offerasked');
        } else {
            return abort(401);
        }
    }

    /**
     * Show contracts
     */
    public function showContracts($id = '')
    {
        $isProvider = true;
        // Get the current service type id ( provider or benf )
        // check if we got the right one before continue
        if ($id) {
            if (in_array($id, Constants::SERVICETYPES)) {
                session()->replace(['service_type' => $id]);    // save to session
            }
        } elseif (session()->get('service_type')) {
            $id = session()->get('service_type');
        } else {
            $id = Constants::SERVICETYPES['provider'];
            session()->replace(['service_type' => $id]);
        }

        if (Constants::SERVICETYPES['provider'] == $id) {
            $newStatus = 'provider_cancel';
            $mycontracts = Contract::byMe()->taqawel()->latest()->paginate(20);
        } else {
            $isProvider = false;
            $newStatus = 'benef_cancel';
            $mycontracts = Contract::toMe()->taqawel()->latest()->paginate(20);
        }

        $reasons = Reason::has('parentReason')->forTaqawelCancel()->pluck('reason', 'id')->toArray();
        $wantDelete = true;
        $reasonLabel = 'contracts.rejection_reason';
        $showTqawelCancelDisclaimers = true;

        return view('front.labor_market.tqawel.taqawel-contracts',
            compact('mycontracts', 'reasons', 'wantDelete', 'newStatus', 'reasonLabel', 'isProvider', 'showTqawelCancelDisclaimers'));
    }


    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editContract($id)
    {
        list($userId, $username) = getCurrentUserNameAndId();
        try {
            $contract = Contract::byMe()->editable()->findOrFail($id);
            $period = getDiffPeriodMonth($contract->start_date, $contract->end_date);
            $contracts = Contract::toMe()->where('id', '!=', $id)->get()->pluck('id', 'id')->toArray();
            $contractNatures = ContractNature::get()->pluck('name', 'id')->toArray();
            $regions = Region::all()->pluck('name', 'id')->toArray();
            $hasInvoices = InvoiceBundle::byMe()->paid()->notExpired()->count();

        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return view('front.labor_market.tqawel.edit',
            compact('userId', 'username', 'contract', 'contractNatures', 'contracts', 'regions', 'hasInvoices','period'));
    }

    /**
     * @param                         $contractId
     * @param TaqawelSendOfferRequest $request
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function updateContract($contractId, TaqawelSendOfferRequest $request)
    {
        $data = array_except($request->only(array_keys($request->rules())),
            ['desc_location', 'file_contract', 'contract_id']);

        try {
            $contract = Contract::findOrFail($contractId);
            if ($contract->status == Constants::CONTRACT_STATUSES['approved']) {
                $data = [];
            }
            if ($request->hasFile('file_contract')) {
                $contract_file = customUploadFile('file_contract', 'tqawel');
                $data['contract_file'] = $contract_file;
            }

            if ($request->file_contract || $request->desc_location) {
                $data['status'] = Constants::CONTRACT_STATUSES['pending'];
                $contract->update($data);
            }
            $contract->contractLocations()->delete();
            if ($request->desc_location) {
                foreach ($request->desc_location as $location) {
                    $contract->contractLocations()->save(new ContractLocation([
                        'branch_id'     => session()->get('selected_establishment.id'),
                        'desc_location' => $location,
                    ]));
                }
            }

        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return trans('labels.updated');
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function applyTaqawelContract($id)
    {
        list($userId, $username) = getCurrentUserNameAndId();
        try {
            $marketServices = MarketTaqawoulServices::byOthers()->findOrFail($id);
            $contracts = Contract::toMe()->hasReference($marketServices)->get()->pluck('id', 'id')->toArray();
            $regions = Region::all()->pluck('name', 'id')->toArray();
            $hasInvoices = InvoiceBundle::byMe()->paid()->notExpired()->count();
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return view('front.labor_market.tqawel.show', compact('id', 'userId', 'username', 'marketServices', 'contracts',
            'regions', 'hasInvoices'));
    }

    /**
     * @param TaqawelSendOfferRequest $request
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function storeTaqawelContract(TaqawelSendOfferRequest $request)
    {
        $data = array_except($request->only(array_keys($request->rules())),
            ['market_taqaual_services_id', 'file_contract', 'desc_location']);
        $service = MarketTaqawoulServices::byBenf()->byOthers()->active()->findOrFail($request->market_taqaual_services_id);
        $contractFile = null;

        if ($request->hasFile('file_contract')) {
            $contractFile = customUploadFile('file_contract', 'tqawel');
        }

        $contract = Contract::create(array_merge($data, [
            'contract_file'              => $contractFile,
            'status'                     => Constants::CONTRACT_STATUSES['pending'],
            'contract_type_id'           => Constants::CONTRACTTYPES['taqawel'],
            'provider_type'              => \Auth::user()->user_type_id,
            'provider_id'                => $service->getCurrentLoginId(),
            'benf_type'                  => $service->service_prvdr_benf_id,
            'benf_id'                    => $service->service_id,
            'contract_nature_id'         => $service->contract_nature_id,
            'market_taqaual_services_id' => $request->market_taqaual_services_id,
        ]));

        // send notify email to beneficial
        \Mail::send('emails.send_taqawel_offer',['contractName' => $contract->contractNature->name, 'contractId' => $contract->id], function ($message) use ($contract) {
            $message->from(config('mail.from.address'))
                    ->to($contract->responsible_email)
                    ->subject(trans('email.subject_send_offer'));
        });

        foreach ($request->desc_location as $location) {
            if (session()->has('selected_establishment.id')) {
                $contract->contractLocations()->save(new ContractLocation([
                    'branch_id'     => session()->get('selected_establishment.id'),
                    'desc_location' => $location,
                ]));
            }
        }

        return trans('labels.sumbitedsucc');
    }

    /**
     * Show recieved Offers
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRecievedOffers()
    {
        $mycontracts = Contract::byMe()->taqawel()->receivedRequest()->latest()->paginate(20);

        return view('front.labor_market.tqawel.received_offers', compact('mycontracts'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReceivedOffersDetails($id, $updated_status = '')
    {
        try {
            $isProvider = true;
            if (session()->get('service_type') == Constants::SERVICETYPES['benf']) {
                $isProvider = false;
            }

            if ($isProvider || $updated_status == 'reject') {
                $contract = Contract::byMe()->with('contractNature', 'contractLocations')->findOrFail($id);
            } else {
                $contract = Contract::toMe()->with('contractNature', 'contractLocations')->findOrFail($id);
            }
            
            if ($updated_status == 'reject') {
                $reasons = Reason::all()->where('parent_id', 2)->pluck('reason', 'id')->toArray();
                $newStatus = 'rejected';
                $wantReject = true;
                $reasonLabel = 'contracts.cancel_reason';
            } elseif ($updated_status == 'cancel') {
                if ($contract->status == "pending" || $contract->status == "approved") {
                    $canCancel = true;
                } else {
                    $canCancel = false;
                }

                $reasons = Reason::has('parentReason')->forTaqawelCancel()->pluck('reason', 'id')->toArray();
                if ($isProvider) {
                    $newStatus = 'provider_cancel';
                } else {
                    $newStatus = 'benef_cancel';
                }
                $wantDelete = true;
                $reasonLabel = 'contracts.rejection_reason';
            } elseif ($updated_status == 'cancel_reset') {
                $newStatus = 'approved';
                $reasonLabel = 'contracts.reset_back_reason';
            }

            if($contract->expired) {
                $contract->status = 'expired';
            }

        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        return view('front.labor_market.tqawel.details',
            compact('contract', 'canCancel', 'reasons', 'wantDelete', 'wantReject', 'newStatus', 'reasonLabel'));
    }


    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancelReceivedOffers($id)
    {
        return $this->showReceivedOffersDetails($id, 'cancel');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function RejectReceivedRequest($id)
    {
        return $this->showReceivedOffersDetails($id, 'reject');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function CancelResetContract($id)
    {
        if (session()->get('service_type') == Constants::SERVICETYPES['provider']) {
            $contract = Contract::byMe()->status(Constants::CONTRACT_STATUSES['provider_cancel'])->findOrFail($id);
        } else {
            $contract = Contract::toMe()->status(Constants::CONTRACT_STATUSES['benef_cancel'])->findOrFail($id);
        }
        $contract->status = Constants::CONTRACT_STATUSES['approved'];

        if ($contract->save()) {
            return trans('tqawel_offer_contract.cancel_reject_success');
        } else {
            return abort(401);
        }
    }
}
