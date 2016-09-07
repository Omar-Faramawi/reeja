<?php

namespace Tamkeen\Ajeer\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Tamkeen\Ajeer\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /*
     * @var redirectTo link
     */
    protected $redirectTo = '/';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateSendResetLinkEmail($request);

        $broker = $this->getBroker();

        $response = Password::broker($broker)->sendResetLink(
            $this->getSendResetLinkEmailCredentials($request),
            $this->resetEmailBuilder()
        );

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return trans('passwords.sent');
            case Password::INVALID_USER:
            default:
                return response()->json(['errors'=>trans('passwords.user')], 422);
        }
    }
    
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $this->validate(
            $request,
            $this->getResetValidationRules(),
            $this->getResetValidationMessages(),
            $this->getResetValidationCustomAttributes()
        );
        
        $credentials = $this->getResetCredentials($request);
        
        $broker = $this->getBroker();
        
        $response = Password::broker($broker)->reset($credentials, function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password),
                'remember_token' => Str::random(60),
            ])->save();
        });
        
        switch ($response) {
            case Password::PASSWORD_RESET:
                return trans('passwords.reset');
            default:
                return response()->json(['errors'=>trans('passwords.token')], 422);
        }
    }
    
}
