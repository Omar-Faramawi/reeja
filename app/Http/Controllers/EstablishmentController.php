<?php

namespace Tamkeen\Ajeer\Http\Controllers;

use Mail;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Models\Establishment;
use Tamkeen\Ajeer\Models\Responsible;
use Tamkeen\Platform\MOL\Repositories\MolDataRepository;
use Tamkeen\Platform\MOL\Exceptions\EstablishmentNotFound;
use Tamkeen\Platform\MOL\Model\EstablishmentNumber;
use Tamkeen\Ajeer\Repositories\MOL\MolDataRepository as MolRepo;


class EstablishmentController extends Controller
{
    var $betaAllowedEstablishments = [153709, 1206561, 1194502, 1028230, 1055720, 930370, 673094, 915262, 703061, 93390, 7054, 223185, 24175, 127442, 84294, 938475, 84295, 1252985, 1786358, 273126, 1022522, 1376974, 188704, 70616, 320985, 4660, 1379841, 55077, 1289427, 1087298, 4506, 76547, 1181149, 2293697, 692958, 1555203, 121038, 55451, 467506, 186431, 1722353, 17057, 129703, 11253, 79286, 629692, 680422, 42346, 124324, 1348230, 743048, 946116, 462232, 242667, 2597216, 1771308, 240752, 963648, 68920, 814995, 136192, 2493100, 2224052, 62399, 1721665, 2119454, 1527052, 2333371, 10746, 1098398, 1575041, 228652, 2027394, 830, 1403138, 24180, 566754, 2763782, 35667, 2032948, 1524000, 2442452, 2434021, 20788, 1600605, 2140404, 18115, 2622566, 1517991, 522044, 1604344, 2271213];
    /**
     * Get the establishments from the session
     * @return mixed
     */
    public function establishments()
    {
        return view('auth.establishments');
    }
    
    /**
     * Choose the establishment link to check i the DB & insert if not exists
     *
     * @param         $laborOffice
     * @param         $sequenceNumber
     * @param MolRepo $mol
     *
     * @return mixed
     */
    public function choose($laborOffice, $sequenceNumber, MolRepo $mol, $login = FALSE)
    {
        try {
            $establishment_data = $mol->findEstablishmentByNumber($laborOffice, $sequenceNumber);
            if (env('APP_ENV') != 'local' && !in_array($establishment_data->FK_establishment_id, $this->betaAllowedEstablishments)) {
                return redirect()->back()->with('choose_est_message', trans('est_profile.beta_unavailable'));
            }
            $owner_id           = $mol->getOwnerByEstablishmentId($establishment_data->FK_establishment_id);
        } catch (EstablishmentNotFound $e) {
            logger()->error('Could not fetch establishment ' . $laborOffice . '-' . $sequenceNumber);
            return redirect()->back();
        }
        $check = Establishment::checkEstablishmentStatus($establishment_data);
        if ($check) {
            return $check;
        }
        $establishment = Establishment::findEstablishmentOrCreate($establishment_data, $owner_id);
        session()->set('selected_establishment', $establishment);
        if($establishment){
            $responsible = $establishment->responsibles()->count();
            if (!$responsible) {
                return redirect()->route('establishment.profile.edit')->with(['msg' => trans('establishment.should_add_responsible'), 'status'=>'block alert-danger']);
            }

            return redirect('home');
        }else{
            return redirect('home');
        }
    }
    
    public function estApproval()
    {
        $establishments = Establishment::where(['hajj' => 1])->whereIn('status',
            [0, 4])->with('responsibles')->get();
        
        return view('front.est_approval.index', compact('establishments'));
    }
    
    public function getResponsibles()
    {
        if (request()->ajax()) {
            $est = Establishment::where(['id' => request()->get('estid'), 'hajj' => 1])->with('responsibles')->first();
            
            $rendered = view('front.est_approval.resp_table')->with(compact('est'))->render();
            
            return response()->json([$rendered], 200);
        }
        
        return view('front.est_approval.resp_table')->with(compact('est'));
        
    }
    
    /**
     * Get current establishment info
     */
    public function edit()
    {
        $est = Establishment::find(session('selected_establishment')->id);
        if (is_null($est)) {
            return abort(404);
        }
        
        return view('front.establishment.profile', compact('est', 'est_resp'));
    }
    
    /**
     * Approve current selected establishment
     */
    public function approve()
    {
        $data = request()->all();
        
        $status = false;
        
        $establishment = Establishment::find($data['estid']);
        
        // Get the next status of Hajj approved establishment based on the current status
        $nextApproveStatus = [
            '0' => 3,
            '4' => 1,
        ];
        
        if (isset($data['action']) && $data['action'] == 'approve') {
            $status = $establishment->update(['status' => $nextApproveStatus[$establishment->status]]);
        } elseif (isset($data['action']) && $data['action'] == 'deny') {
            $status = $establishment->update(['status' => 2]);
        }
        
        // Sending an email for the establishment with the approval/rejection status
        try {
            Mail::queue('emails.est_approval', ['establishment' => $establishment, 'status' => isset($data['approve'])],
                function ($message) use ($establishment) {
                    $message->from(config('mail.from'))
                        ->to($establishment->email)
                        ->subject('Ajeer');
                });
        } catch (\Swift_RfcComplianceException $e) {
            
        }
        
        if ($status) {
            return trans('labels.updated');
        }
        
        return response()->json(['errors' => 'error'], 422);
    }
    
    /**
     * Adding and updating establishment responsibles
     */
    
    public function update(Requests\UpdateEstResponsiblesRequest $request)
    {
        $data = $request->only(array_keys($request->rules()));
        if (count($data['resp_data']) < 1) {
            return response()->json(['errors' => trans('est_profile.at_least_one')], 422);
        }
        
        if (!request()->has('ignore_est_type')) {
            $establishment = session('selected_establishment');
            
            $establishment->hajj     = isset($data['est_type']['hajj']) ? $data['est_type']['hajj'] : null;
            $establishment->catering = isset($data['est_type']['catering']) ? $data['est_type']['catering'] : null;

            $establishment->save();
        }
        
        foreach ($data['resp_data'] as $key => $value) {
            if (isset($value['id'])) {
                Responsible::find($value['id'])->update(array_except($value, 'id'));
            } else {
                $value['establishments_id'] = session('selected_establishment')->id;
                $resp                       = new Responsible();
                $resp->fill($value);
                $resp->save();
            }
        }
        
        if (request()->ajax()) {
            return trans('est_profile.updated');
        }
        
        return redirect()->back()->withInput();
    }
}
