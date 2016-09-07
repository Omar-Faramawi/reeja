<?php

namespace Tamkeen\Ajeer\Http\Controllers\Auth;

use Tamkeen\Ajeer\Http\Requests\LoginRequest;
use Tamkeen\Ajeer\Http\Requests\IndividualsLoginRequest;
use Tamkeen\Ajeer\Models\User;
use Tamkeen\Ajeer\Models\Individual;
use Tamkeen\Ajeer\Models\IndividualLabor;
use Tamkeen\Ajeer\Models\HRPool;
use Tamkeen\Ajeer\Models\Job;
use Validator;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Carbon\Carbon;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Tamkeen\Platform\MOL\Model\EstablishmentNumber;
use Tamkeen\Platform\MOL\Repositories\MolDataRepository;
use Tamkeen\Platform\MOL\OpenId\AuthenticationFailedException;
use Tamkeen\Platform\MOL\OpenId\OpenIdService;
use Tamkeen\Platform\NIC\Repositories\Citizens\CitizensRepository;
use Tamkeen\Platform\NIC\Repositories\Citizens\CitizenDataNotFoundException;
use Tamkeen\Platform\NIC\Repositories\Foreigners\ForeignersRepository;
use Tamkeen\Platform\NIC\Repositories\Foreigners\ForeignerDataNotFoundException;
use Tamkeen\Platform\Model\Common\HijriDate;
use Tamkeen\Platform\Model\NIC\IdNumber;

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
     * Create a new authentication controller instance.
     *
     * @return void
     */

    public function __construct(CitizensRepository $cnic, ForeignersRepository $fnic)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->citizensNic   = $cnic;
        $this->foreignersNic = $fnic;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected function validator(array $data)
    {
        if (isset($data['birth_date']) && $data['birth_date'] != "") {
            $date = explode("-", $data['birth_date']);
        } else {
            $date = 0;
        }

        // Custom NIC validation Rule
        Validator::extend('nic', function ($attribute, $value, $parameters, $validator) use ($date) {
            if ($this->checksum($value) == 1) {
                if (substr($value, 0, 1) == "1" && $date != 0) {
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

                        return isset($this->foreigner);
                    } catch (ForeignerDataNotFoundException $e) {
                        return false;
                    }
                }
            } else {
                return false;
            }
        });

        // set nic custom error message
        $messages = [
            'nic'         => trans('registration.validation.nicerror'),
            'required_if' => trans('registration.validation.required_if'),
        ];

        // set attributes
        $attributes = [
            'id_number'  => trans('registration.attributes.id_number'),
            'birth_date' => trans('registration.attributes.birth_date'),
            'saudi'      => trans('registration.attributes.saudi'),
            'religion'   => trans('registration.attributes.religion'),
        ];

        $rules = [
            'saudi'      => 'sometimes',
            'id_number'  => 'bail|required|digits:10|unique:hr_pool|nic',
            'birth_date' => 'required_if:saudi,1',
            'first_name' => 'required|min:2|max:255',
            'last_name'  => 'required|min:2|max:255',
            'email'      => 'required|email|max:255|unique:users',
            'password'   => 'required|min:6|confirmed',
            'phone'      => 'required|numeric|min:6',
            'religion'   => 'required',
            'gender'     => 'required',
        ];


        $validator = Validator::make($data, $rules, $messages, $attributes);

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
            $ownership_id   = $this->foreigner->sponsor->getIdNumber();
            $ownership_name = $this->foreigner->sponsor->getName();
            $user_type_id   = 5;
            $job_id         = null;
            $birth_date     = $this->foreigner->getBirthDate();
        } else {
            $ownership_id   = null;
            $ownership_name = null;
            $user_type_id   = 4;
            $occupation     = $this->citizen->getOccupation();
            $job            = Job::where('job_name', $occupation)->first();
            $job_id         = !empty($job->id) ? $job->id : null;
            $birth_date     = $this->citizen->getBirthDate();
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
            'gender'         => $data['gender'],
            'religion'       => $data['religion'],
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
            'gender'               => $data['gender'],
            'job_id'               => $job_id,
            'email'                => $data['email'],
            'chk'                  => '0',
            'indviduals_id_number' => $individual->id,
        ]);

        // Save into hr pool

        $hr_pool = HRPool::create([
            'id_number'     => $data['id_number'],
            'provider_type' => $user_type_id,
            'provider_id'   => $individual->id,
            'name'          => $data['first_name'] . " " . $data['last_name'],
            'gender'        => $data['gender'],
            'job_id'        => $job_id,
            'email'         => $data['email'],
            'phone'         => $data['phone'],
            'birth_date'    => $birth_date,
            'religion'      => $data['religion'],
            'chk'           => '0',
            'status'        => '1',
        ]);

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

            if (!empty($userData['establishments'])) {
                foreach ($userData['establishments'] as $LO_SN => $establishment) {

                    list($labor_office, $sequence_number) = explode('-', $LO_SN);
                    $mol                                = $molDataRepository
                        ->getEstablishmentByNumber(
                            EstablishmentNumber::make($labor_office,
                                $sequence_number));
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
        session()->forget('selected_establishment');
        session()->flush();

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

                return $this->sendLockoutResponse($request);
            }

            if ($auth->attempt($request->only('national_id', 'password'))) {
                $user_obj = $auth->user();
                if ($user_obj->active) {
                    session()->set('auth.type', $user_obj->user_type_id);
                    session()->set('user', $user_obj);

                    return trans('auth.success');
                } else {
                    $auth->logout();

                    return response()->json(['error' => trans('auth.messages.invalid_nid_password')], 422);
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
    public function login(LoginRequest $request, Guard $auth)
    {
        try {
            $throttles = $this->isUsingThrottlesLoginsTrait();
            if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return response()->json(['error' => trans('auth.messages.exceeded_failure_threshold')], 422);
            }

            if ($auth->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                $user_obj = User::find($auth->user()->id);
                if ($user_obj->active && $user_obj->user_type_id > 1) {
                    if ($user_obj->user_type_id == 2) {
                        $gov = $user_obj->load('government');
                        session()->set('government', $gov->government);
                    } elseif ($user_obj->user_type_id == 3) {
                        $est = $user_obj->load('establishment');
                        session()->set('selected_establishment', $est);
                    }
                    session()->set('auth.type', $user_obj->user_type_id);

                    return trans('auth.success');
                } else {
                    $auth->logout();

                    return response()->json(['error' => trans('auth.messages.invalid_username_password')], 422);
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
}
