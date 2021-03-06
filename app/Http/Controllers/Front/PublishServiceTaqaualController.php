<?php

namespace Tamkeen\Ajeer\Http\Controllers\Front;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests\PublishServiceRequest;
use Tamkeen\Ajeer\Http\Requests\TaqawelServicesRequest;
use Tamkeen\Ajeer\Models\BaseModel;
use Tamkeen\Ajeer\Models\ContractNature;
use Tamkeen\Ajeer\Models\InvoiceBundle;
use Tamkeen\Ajeer\Models\MarketTaqawoulServices;
use Tamkeen\Ajeer\Utilities\Constants;

class PublishServiceTaqaualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice_bundles = InvoiceBundle::byMe()->paid()->notExpired()->hasRemainingNotices()->get();
        if (!count($invoice_bundles)) {
            return redirect('taqawel/packagesubsribe')->with('msg_error',
                trans('packagesubscribe.shouldChoosePackage'));
        }
        if (request()->ajax()) {
            $services = MarketTaqawoulServices::byMe()->byProviders()->with('contractNature');
            $columns  = request()->input('columns');
            
            if (request()->input('id')) {
                $services = $services->where('id', request()->input('id'));
            }
            
            if (request()->input('description')) {
                $services = $services->where('description', 'LIKE', '%' . request()->input('description') . '%');
            }
            if (request()->input('service_id')) {
                $services = $services->whereHas('contractNature', function ($q) {
                    $q->where('name', 'LIKE', '%' . request()->input('service_id') . '%');
                });
            }
            $total_count = ($services->count()) ? $services->count() : 1;
            
            $buttons = [
                'edit'   => [
                    "text"        => trans("taqawoul.buttons.edit"),
                    "url"         => url("/taqawel/publishservice"),
                    "uri"         => "edit",
                    "css_class"   => "blue",
                    'serviceEdit' => true,
                ],
                'delete' => [
                    "text"          => trans("taqawoul.buttons.delete"),
                    "url"           => url("/taqawel/publishservice"),
                    "uri"           => "delete",
                    "css_class"     => "red delete_taqawel_service",
                    'serviceDelete' => true,
                ],
            ];
            
            return dynamicAjaxPaginate($services, $columns, $total_count, $buttons);
        }
        $can_add = BaseModel::estCanBeProvider();

        return view("front.taqawel.publishservice.index", compact('can_add'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (BaseModel::estCanBeProvider()) {
            $service_types = ContractNature::active()->get()->pluck("name", "id");
            $service_types["other"] = trans("offers.modal.reject.other");

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
            if (Cache::has('publish_taqawel_service.' . $id)) {
                $cached_data = Cache::pull('publish_taqawel_service.' . $id);
            }

            return view("front.taqawel.publishservice.create", compact("service_types", 'cached_data'));
        }else {
            return abort(401);
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param PublishServiceRequest $publishServiceRequest
     *
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function store(PublishServiceRequest $publishServiceRequest)
    {
        if (BaseModel::estCanBeProvider()) {
            $data = $publishServiceRequest->only(['contract_nature_id', 'new_service', 'description']);

            if ($publishServiceRequest->get('save_action') == 'draft') {
                if (session()->get('selected_establishment')) {
                    $id = session()->get('selected_establishment.id');
                } elseif (session()->get('government')) {
                    $id = session()->get('government.id');
                } else {
                    $id = auth()->user()->id_no;
                }

                Cache::put('publish_taqawel_service.'.$id, $data, 7200);
                return trans('taqawoul.success_data');
            }

            $data['status']                = '1';
            if ($data['contract_nature_id']=='other') {
                $new_nature                 = ContractNature::create(['name' => $publishServiceRequest->input('new_service'), 'status' => 0]);
                $data['contract_nature_id'] = $new_nature->id;
                unset($data['new_service']);
            } else {
                unset($data['new_service']);
            }
            $data['provider_or_benf']      = Constants::SERVICETYPES['provider'];
            $data['service_prvdr_benf_id'] = \Auth::user()->user_type_id;
            $current                       = getCurrentUserNameAndId();
            $data['service_id']            = $current[0];
            $save                          = MarketTaqawoulServices::create($data);

            return trans('taqawoul.success_data');
        }else {
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
        $service       = MarketTaqawoulServices::with('contractNature')->findOrFail($id);
        $service_types = ContractNature::active()->get()->pluck("name", "id");
        if (!isset($service_types[$service->contract_nature_id])) {
            $service_types[$service->contract_nature_id] = $service->contractNature->name;
        }
        $service_types["other"] = trans("offers.modal.reject.other");
        $cached_data = [
            'contract_nature_id' => $service->contract_nature_id,
            'new_service' => null,
            'description' => $service->description
        ];
        
        return view("front.taqawel.publishservice.create", compact("service", "service_types", 'cached_data'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param PublishServiceRequest $publishServiceRequest
     * @param  int                  $id
     *
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function update(PublishServiceRequest $publishServiceRequest, $id)
    {
        $service = MarketTaqawoulServices::findOrFail($id);
        $data    = $publishServiceRequest->only(array_keys($publishServiceRequest->rules()));
        if ($data['contract_nature_id']=='other') {
            $new_nature                 = ContractNature::create(['name' => $publishServiceRequest->input('new_service'), 'status' => 0]);
            $data['contract_nature_id'] = $new_nature->id;
            unset($data['new_service']);
        } else {
            unset($data['new_service']);
        }
        $service->update($data);
        
        return trans("publishservice.updated");
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
}
