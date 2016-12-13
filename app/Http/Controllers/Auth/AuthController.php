<?php

namespace Tamkeen\Ajeer\Http\Controllers\Auth;

use Tamkeen\Ajeer\Http\Requests\LoginRequest;
use Tamkeen\Ajeer\Http\Requests\IndividualsLoginRequest;
use Tamkeen\Ajeer\Models\User;
use Tamkeen\Ajeer\Models\Individual;
use Tamkeen\Ajeer\Models\IndividualLabor;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Job;
use Tamkeen\Ajeer\Models\Nationality;

use Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Carbon\Carbon;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Tamkeen\Platform\MOL\Model\EstablishmentNumber;
use Tamkeen\Ajeer\Repositories\MOL\MolDataRepository;
use Tamkeen\Platform\MOL\OpenId\AuthenticationFailedException;
use Tamkeen\Platform\MOL\OpenId\OpenIdService;
use Tamkeen\Platform\NIC\Repositories\Citizens\CitizensRepository;
use Tamkeen\Platform\NIC\Repositories\Citizens\CitizenDataNotFoundException;
use Tamkeen\Platform\NIC\Repositories\Foreigners\ForeignersRepository;
use Tamkeen\Platform\NIC\Repositories\Foreigners\ForeignerDataNotFoundException;
use Tamkeen\Platform\Model\Common\HijriDate;
use Tamkeen\Platform\Model\NIC\IdNumber;
use Tamkeen\Ajeer\Repositories\MOL\MolDataRepository as MolRepo;
use Tamkeen\Platform\NIC\Services\AuthenticateViaMobile\AuthenticateViaMobileService;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Define the username
     * @var string
     */
    protected $username = 'email';

    /**
     * Define the Citizen nic
     * @var object
     */
    protected $citizensNic;

    /**
     * Define the foreigners nic
     * @var object
     */
    protected $foreignersNic;

    /**
     * Define the Citizen nic
     * @var object
     */
    protected $citizen;

    /**
     * Define the foreigners nic
     * @var object
     */
    protected $foreigner;

    /**
     * Define the Absher service
     * @var object
     */
    protected $absher;

    /**
     * Create a new authentication controller instance.
     *
     * @param CitizensRepository $cnic
     * @param ForeignersRepository $fnic
     * @param AuthenticateViaMobileService $absher
     */

    public function __construct(CitizensRepository $cnic, ForeignersRepository $fnic, AuthenticateViaMobileService $absher)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->citizensNic   = $cnic;
        $this->foreignersNic = $fnic;
        $this->absher = $absher;
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $isSaudi = (substr($data['id_number'], 0, 1) == "1");

        if ($isSaudi && !$validator->fails()) {
            //store registration in session
            session(['temp_account_registration' => $data]);
            // invoke sms service
            if (env('APP_ENV') == 'local') {
                $activationNumber = $this->absher->authenticateViaMobile($data['id_number'], "123123");
            }else{
                $activationNumber = $this->absher->authenticateViaMobile($data['id_number']);
            }

            session()->push('temp_account_registration.activation_number', $activationNumber);

            return redirect("/activation");
        }

        Auth::guard($this->getGuard())->login($this->create($request->all()));

        return redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @param AuthenticateViaMobileService $service
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        $isSaudi = (substr($data['id_number'], 0, 1) == "1");

        $rules = [
            'birth_date'        => 'bail|required|date',
            'id_number'         => 'bail|required|digits:10|unique:hr_pool,id_number,0,id,deleted_at,NULL',
            'first_name'        => 'required|min:2|max:255',
            'last_name'         => 'required|min:2|max:255',
            'email'             => 'required|email|max:255|unique:users,email,0,id,deleted_at,NULL',
            'password'          => 'required|min:6|confirmed',
            'phone'             => 'required|numeric|digits:10',
            'activation_number' => 'sometimes|required',
        ];

        $attributes = [
            'id_number'  => trans('registration.attributes.id_number_saudi'),
            'birth_date' => trans('registration.attributes.birth_date'),
        ];

        $validator = Validator::make($data, $rules, [], $attributes);

        if ($validator->fails()) {
            return $validator;
        }

        $date = explode("-", $data['birth_date']);

        // Custom NIC validation Rule
        Validator::extend('nic', function ($attribute, $value, $parameters, $validator) use ($date, $isSaudi) {
            if ($this->checksum($value) == 1) {
                if ($isSaudi) {
                    try {
                        $this->citizen = $this->citizensNic->fetchCitizen(IdNumber::fromString($value),
                            HijriDate::fromDate(intval($date[0]), intval($date[1]), intval($date[2])),
                            IdNumber::fromInt(config('nic.operatorId')));

                        return isset($this->citizen);
                    } catch (CitizenDataNotFoundException $e) {
                        return false;
                    }
                } else {
                    try {
                        $this->foreigner = $this->foreignersNic->fetchForeigner(IdNumber::fromString($value),
                            IdNumber::fromInt(config('nic.operatorId')));
                        //TODO: check for birth date
                        return isset($this->foreigner);
                    } catch (ForeignerDataNotFoundException $e) {
                        return false;
                    }
                }
            } else {
                return false;
            }
        });

        Validator::extend('nic_not_active', function ($attribute, $value, $parameters, $validator) {
            $status = 0;
            if (isset($this->citizen)) {
                $status = $this->citizen->getStatus()->getPersonStatus()->getCode();
            } elseif (isset($this->foreigner)) {
                $status = $this->foreigner->getStatus()->getPersonStatus()->getCode();
            }

            if ($status != 1) {
                return false;
            }

            return true;
        });

        // set nic custom error message
        $messages = [
            'nic'           => ($isSaudi ? trans('registration.validation.nicerror_saudi') : trans('registration.validation.nicerror_non_saudi')),
            'nic_not_active'=> trans('registration.validation.nic_not_active'),
        ];

        $rules = [
            'id_number'  => 'nic|nic_not_active',
        ];

        $validator = Validator::make($data, $rules, $messages, $attributes);

        if ($isSaudi && !isset($data['activation_number']) && !$validator->fails()) {
            //store registration in session
            session(['temp_account_registration' => $data]);
            // invoke sms service
            if (env('APP_ENV') == 'local') {
                $activationNumber = $this->absher->authenticateViaMobile($data['id_number'], "123123");
            }else{
                $activationNumber = $this->absher->authenticateViaMobile($data['id_number']);
            }

            session()->push('temp_account_registration.activation_number', $activationNumber);

            redirect("/activation");
        }

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {

        if (isset($this->foreigner)) {
            $ownership_id      = $this->foreigner->sponsor->getIdNumber();
            $ownership_name    = $this->foreigner->sponsor->getName();
            $user_type_id      = 5;
            $job_id            = null;
            $birth_date        = $this->foreigner->getBirthDate();
            $nationality       = $this->foreigner->getNationality();
            $ajeer_nationality = Nationality::where('name', $nationality)->orWhere('eng_name', $nationality)->first();
            $nationality_id    = $ajeer_nationality->id;
            $gender            = $this->foreigner->getGender();
        } else {
            $ownership_id   = null;
            $ownership_name = null;
            $user_type_id   = 4;
            $occupation     = $this->citizen->getOccupation();
            $job            = Job::where('job_name', $occupation)->first();
            $job_id         = !empty($job->id) ? $job->id : null;
            $birth_date     = $this->citizen->getBirthDate();
            $nationality_id = 1;
            $gender         = $this->citizen->getGender();
        }

        if ($gender == '2') {
            $gender = '0';
        }
        
        $arr        = (array)$birth_date;
        $prefix     = chr(0) . '*' . chr(0);
        $hijri      = $arr[$prefix . 'hijriDate'];
        $arr2       = (array)$hijri;
        $birth_date = $arr2[$prefix . 'year'] . '-' . $arr2[$prefix . 'month'] . '-' . $arr2[$prefix . 'day'];

        // Save into Individuals
        $individual = Individual::create([
            'nid'            => $data['id_number'],
            'ownership_id'   => $ownership_id,
            'ownership_name' => $ownership_name,
            'name'           => $data['first_name'] . ' ' . $data['last_name'],
            'phone'          => $data['phone'],
            'gender'         => $gender,
            'religion'       => 1, //TODO: get religion from NIC
            'email'          => $data['email'],
            'user_type_id'   => $user_type_id,
        ]);
        // Save into Users
        $user = User::create([
            'name'         => $data['first_name'] . " " . $data['last_name'],
            'email'        => $data['email'],
            'password'     => bcrypt($data['password']),
            'id_no'        => $individual->id,
            'user_type_id' => $user_type_id,
            'national_id'  => $data['id_number'],
            'active'       => '1',
        ]);

        // Save into Individual Labors
        $individual_labors = IndividualLabor::create([
            'id_number'            => $data['id_number'],
            'name'                 => $data['first_name'] . " " . $data['last_name'],
            'phone'                => $data['phone'],
            'gender'               => $gender,
            'job_id'               => $job_id,
            'email'                => $data['email'],
            'chk'                  => '0',
            'indviduals_id_number' => $individual->id,
        ]);

        // Save into hr pool

        $hr_pool = HRPool::create([
            'id_number'      => $data['id_number'],
            'provider_type'  => $user_type_id,
            'provider_id'    => $individual->id,
            'name'           => $data['first_name'] . " " . $data['last_name'], //TODO: get name from NIC
            'gender'         => $gender,
            'job_id'         => $job_id,
            'email'          => $data['email'],
            'phone'          => $data['phone'],
            'birth_date'     => $birth_date,
            'religion'       => 1, //TODO: get religion from NIC
            'nationality_id' => $nationality_id,
            'chk'            => '0',
            'status'         => '1',
        ]);

        session()->set('auth.type', $user_type_id);

        return $user;
    }

    /**
     * Redirect the user to the authentication page.
     *
     * @param OpenIdService $openIdService
     *
     * @return Response
     */
    public function redirectToOpenID(OpenIdService $openIdService)
    {
        return redirect($openIdService->getAuthenticationEndpoint());
    }

    /**
     * Obtain the user information from OpenID.
     *
     * @param OpenIdService     $openIdService
     * @param Request           $request
     * @param Guard             $auth
     * @param MolDataRepository $molDataRepository
     *
     * @return Response
     */
    public function handleOpenIDCallback(
        OpenIdService $openIdService,
        Request $request,
        Guard $auth,
        MolDataRepository $molDataRepository
    ) {
        try {
            $userData = $openIdService->authenticate($request);
            
            if (env('APP_ENV') == 'local') {
                $dummyEstablishments = config('mol.data.establishments');
                if($dummyEstablishments) {
                    $userData['establishments'] = [];
                    foreach ($dummyEstablishments as $est) {
                        $userData['establishments'][$est['labor_office_id'].'-'.$est['sequence_number']] = $est['name'];
                    }
                }
            }
            if (!empty($userData['establishments'])) {
                foreach ($userData['establishments'] as $LO_SN => $establishment) {

                    list($labor_office, $sequence_number) = explode('-', $LO_SN);

                    $mol = $molDataRepository->findEstablishmentByNumber($labor_office, $sequence_number);

                    $userData['establishments'][$LO_SN] = $mol;
                }
            }
        } catch (AuthenticationFailedException $e) {
            return redirect($openIdService->getAuthenticationEndpoint());
        }


        try {
            $user = User::findByIdNumberOrCreate(data_get($userData, 'id_number'), $userData, false);
        } catch (\Exception $e) {
            return redirect($openIdService->getLogoutUrl())->with('message', [
                'type' => 'danger',
                'text' => trans('auth.messages.inactive_user_account'),
            ]);
        }

        $auth->login($user);

        session()->set('user.establishments', array_get($userData, 'establishments', []));
        session()->set('auth.type', 'mol');
        session()->save();

        return redirect()->route('establishment.select');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(OpenIdService $openIdService)
    {
        if(Auth::check()){
        	$user_type = Auth::user()->user_type_id;

    	    if( $user_type == 1 ) {
    	        // then it's admin
    		    Auth::guard($this->getGuard())->logout();
    		    return redirect()->intended('/admin');
    	    }

    	    session()->forget('selected_establishment');
    	    session()->flush();
        }

	    return redirect($openIdService->getLogoutUrl());

    }

    /**
     * @param string $idNumber
     *
     * @return bool
     */
    protected static function checksum($idNumber)
    {
        $sum    = 0;
        $digits = str_split($idNumber);

        for ($i = 0; $i < 10; ++$i) {
            if ($i % 2 == 0) {
                $s = $digits[$i] * 2;
                $sum += $s % 10 + floor($s / 10);
            } else {
                $sum += $digits[$i];
            }
        }

        return $sum % 10 === 0;
    }

    /**
     * Handle an individual login request to the application.
     *
     * @param LoginRequest|\Tamkeen\Ajeer\Http\Requests\IndividualsLoginRequest $request
     * @param Guard                                                             $auth
     *
     * @return \Illuminate\Http\Response
     */
    public function individualsLogin(IndividualsLoginRequest $request, Guard $auth)
    {
        try {
            $throttles = $this->isUsingThrottlesLoginsTrait();
            if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return response()->json(['error' => trans('auth.throttle', ['seconds' => $this->secondsRemainingOnLockout($request)])], 422);
            }

            if ($auth->attempt($request->only('national_id', 'password'))) {
                $user_obj = $auth->user();
                if ($user_obj->active) {
                    session()->set('auth.type', $user_obj->user_type_id);
                    session()->set('user', $user_obj);

                    return trans('auth.success');
                } else {
                    $auth->logout();

                    return response()->json(['error' => trans('auth.messages.inactive_user_account')], 422);
                }
            } else {
                if ($throttles && !$lockedOut) {
                    $this->incrementLoginAttempts($request);
                }

                return response()->json(['error' => trans('auth.messages.invalid_nid_password')], 422);

            }
        } catch (AuthenticationThresholdExceededException $e) {
            return response()->json(['error' => trans('auth.messages.exceeded_failure_threshold')], 422);
        }
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Tamkeen\Ajeer\Http\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request, Guard $auth, MolRepo $mol)
    {
        
        try {
            $throttles = $this->isUsingThrottlesLoginsTrait();
            if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return response()->json(['error' => trans('auth.throttle', ['seconds' => $this->secondsRemainingOnLockout($request)])], 422);
            }

            if ($auth->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                $user_obj = User::find($auth->user()->id);
                if ($user_obj->active && $user_obj->user_type_id > 1) {
                    if ($user_obj->user_type_id == 2) {
                        $gov = $user_obj->load('government');
                        session()->set('government', $gov->government);
                    } elseif ($user_obj->user_type_id == 3) {
                        $est = $user_obj->load('establishment');
                      
                      app('Tamkeen\Ajeer\Http\Controllers\EstablishmentController')->choose($est->establishment->labour_office_no, $est->establishment->sequence_no, $mol, TRUE);
                      if(session()->has('choose_est_message')){
                          $msg = session()->pull('choose_est_message');
                          session()->forget('selected_establishment');
                          session()->flush();
                          return response()->json(['error' => $msg], 422);
                      }
                      
                    }

                    return trans('auth.success');
                } else {
                    $auth->logout();

                    return response()->json(['error' => trans('auth.messages.invalid_username_password')], 422);
                }
            } else {
                if ($throttles && !$lockedOut) {
                    $this->incrementLoginAttempts($request);
                }

                return response()->json(['error' => trans('auth.messages.invalid_username_password')], 422);
            }
        } catch (AuthenticationThresholdExceededException $e) {
            return response()->json(['error' => trans('auth.messages.exceeded_failure_threshold')], 422);
        }
    }

    public function activation(Request $request)
    {
        $data = $request->all();
      
        if(session()->has('temp_account_registration') && session('temp_account_registration.activation_number')[0] == $data['activation_number'])
        {
            $validator = $this->validator(session('temp_account_registration'));
            if($validator->fails()){
                    return response($validator->errors(), 403)->header('Content-Type', 'application/json');
            }else{
                Auth::guard($this->getGuard())->login($this->create(session('temp_account_registration')));
            }
        }else{
            return response(['error' => trans('registration.wrong_activation')], 403)->header('Content-Type', 'application/json');
        }
    }
}
