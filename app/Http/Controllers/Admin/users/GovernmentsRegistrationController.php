<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Tamkeen\Ajeer\Http\Requests;
use Tamkeen\Ajeer\Http\Requests\GovernmentsRegisterRequest;
use Tamkeen\Ajeer\Models\Government;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Tamkeen\Ajeer\Models\User;
use Mail;

class GovernmentsRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Government::latest()->paginate(20);
        
        return view('admin.users.governments.list', compact('data'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.governments.edit');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\GovernmentsRegisterRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(GovernmentsRegisterRequest $request)
    {
        $data     = $request->only(array_keys($request->rules()));
        $gov_user = Government::create($data);
        
        // create government user
        $user_data = [
            'email'        => $request->input('email'),
            'name'         => $request->input('name'),
            'id_no'        => $gov_user->id,
            'user_type_id' => '2',
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
        $data = Government::byId($id)->firstOrFail();
        
        return view('admin.users.governments.edit', compact('data'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\GovernmentsRegisterRequest $request
     * @param  int                                 $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(GovernmentsRegisterRequest $request, $id)
    {
        $data        = Government::byId($id)->with('users')->firstOrFail();
        $update_data = $request->only(['name', 'hajj']);
        $data->fill($update_data);
        $data->save();
        
        // Update the user data
        $data->users()->update(['name' => $data->name]);
        
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
        $data = Government::byId($id)->with('users')->firstOrFail();
        $data->users()->delete();
        $data->delete();
        
        return trans('governments_registeration.deleted');
    }
}
