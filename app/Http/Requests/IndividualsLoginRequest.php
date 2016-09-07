<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class IndividualsLoginRequest extends Request
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
     * Get the localization attributes.
     *
     * @return array
     */
	public function attributes()
	{
		return [
			'national_id' => trans('auth.parameters.national_id')
		];
	}
	
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'national_id'    => 'required|numeric|digits:10',
            'password' 		 => 'required|min:6',
        ];
    }
}
