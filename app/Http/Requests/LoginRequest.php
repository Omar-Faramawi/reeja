<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ];
    }


    public function messages()
    {
      return [
        'email.required'    => trans('auth.messages.invalid_username_password'),
        'email.email'       => trans('auth.messages.invalid_username_password'),
        'password.required' => trans('auth.messages.invalid_username_password'),
        'password.min'      => trans('auth.messages.invalid_username_password'),
      ];
    }
}
