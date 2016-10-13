<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\EstablishmentRegisterRequest;
use Tamkeen\Ajeer\Models\Establishment;
use Tamkeen\Ajeer\Repositories\MOL\MolDataRepository;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Tamkeen\Ajeer\Models\User;
use Illuminate\Support\Facades\Password;
use Mail;

class EstablishmentsRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Establishment::latest()->paginate(20);
        
        return view('admin.users.establishments.list', compact('data'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.establishments.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  EstablishmentRegisterRequest $request
     * @param MolDataRepository             $mol
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EstablishmentRegisterRequest $request, MolDataRepository $mol)
    {
        // check on the establishment
        $labour_office_no = $request->input('labour_office_no');
        $sequence_no      = $request->input('sequence_no');
        $establishment    = $mol->findEstablishmentByNumber($labour_office_no, $sequence_no);
        if (empty($establishment)) {
            return response()->json(['error' => trans('establishments_registration.no_data')], 422);
        }
        
        // create establishment
        $est_data                      = new Establishment;
        $est_data->name                = $establishment->name;
        $est_data->email               = $request->input('email');
        $est_data->branch_no           = $request->input('branch_no');
        $est_data->labour_office_no    = $establishment->labor_office_id;
        $est_data->sequence_no         = $establishment->sequence_number;
        $est_data->id_number           = $mol->getOwnerByEstablishmentId($establishment->FK_establishment_id);
        $est_data->FK_establishment_id = $establishment->FK_establishment_id;
        $est_data->est_activity        = $establishment->economic_activity;
        $est_data->est_size            = $establishment->size_id;
        $est_data->est_nitaq           = $establishment->nitaqat_color;
        $est_data->district            = $establishment->district;
        $est_data->city                = $establishment->city;
        $est_data->region              = $establishment->region;
        $est_data->wasel_address       = $establishment->street . ' - ' . $establishment->region . ' - ' . $establishment->city;
        $est_data->local_liecense_no   = $establishment->cr_number;
        $est_data->phone               = $establishment->phone;
        $est_data->status              = '1';
        $est_data->save();
        
        // create government user
        $user_data = [
            'email'        => $request->input('email'),
            'name'         => $request->input('name'),
            'id_no'        => $est_data->id,
            'user_type_id' => '3', // for establishment users
            'active'       => '1',
        ];
        $user      = User::create($user_data);
        $token     = Password::getRepository()->create($user);
        
        // Sending set password email
        Mail::queue('auth.emails.password', ['token' => $token], function ($m) use ($user_data) {
            $m->from(config('mail.from.address'), config('mail.from.name'));
            $m->to($user_data['email']);
            $m->subject(trans('auth.forget_pass_email_subject'));
        });
        
        return trans('governments_registeration.added');
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
        $this->edit($id);
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
        $data = Establishment::byId($id)->firstOrFail();
        
        return view('admin.users.establishments.edit', compact('data'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data            = Establishment::byId($id)->with('users')->firstOrFail();
        $data->status    = $request->input('status') ? "1" : "0";
        $data->branch_no = $request->input('branch_no');
        $data->save();
        
        // Update the user data
        $data->users()->update(['active' => $data->status]);
        
        return trans('governments_registeration.updated');
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
        $data = Establishment::byId($id)->with('users')->firstOrFail();
        $data->users()->delete();
        $data->delete();
        
        return trans('governments_registeration.deleted');
    }
    
    /**
     * Collect establishment data from MOL DB
     *
     * @param MolDataRepository $mol
     * @param Request           $request
     *
     * @return array
     *
     */
    public function establishmentData(MolDataRepository $mol, Request $request)
    {
        $id_number        = $request->input('id_number');
        $labour_office_no = $request->input('labour_office_no');
        $sequence_no      = $request->input('sequence_no');
        $establishment    = $mol->findEstablishmentByOwner($id_number, $labour_office_no, $sequence_no);
        $return_arr       = ['status' => false];
        if ($establishment) {
            $return_arr['status'] = true;
            $return_arr['est']    = $establishment;
            
            return $return_arr;
        }
        
        return $return_arr;
    }
}
