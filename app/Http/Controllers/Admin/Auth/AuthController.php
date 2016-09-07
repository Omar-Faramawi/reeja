<?php

namespace Tamkeen\Ajeer\Http\Controllers\Admin\Auth;

use Tamkeen\Ajeer\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use Carbon\Carbon;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Tamkeen\Ajeer\Http\Requests\LoginRequest;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        $view = property_exists($this, 'loginView')
            ? $this->loginView : 'auth.authenticate';

        if (view()->exists($view)) {
            return view($view);
        }

        return view('admin.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Tamkeen\Ajeer\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(LoginRequest $request, Guard $auth)
    {
        try {
            $throttles = $this->isUsingThrottlesLoginsTrait();
            if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }

            if ($auth->attempt($request->only('email', 'password'))) {
                $user_obj = $auth->user();
                if ($user_obj->active == 1) {
                    session()->set('auth.type', $user_obj->user_type_id);
                    return redirect()->intended('/admin');
                } else {
                    $auth->logout();
                    return redirect()->back()
                        ->withErrors(trans('auth.messages.inactive_user_account'))
                        ->withInput();
                }
            } else {
                if ($throttles && ! $lockedOut) {
                    $this->incrementLoginAttempts($request);
                }
                return redirect()->back()
                    ->withErrors(trans('auth.messages.invalid_username_password'))
                    ->withInput($request->only('email'));
            }
        } catch (AuthenticationThresholdExceededException $e) {
            return redirect()->back()
                ->withErrors(trans('auth.messages.exceeded_failure_threshold'))
                ->withInput();
        }
    }
}
