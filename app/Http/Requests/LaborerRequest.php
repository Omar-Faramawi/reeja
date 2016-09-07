<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Hashids;

class LaborerRequest extends Request
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

            'id_number'    => 'required|digits:10|unique:hr_pool'
        ];
    }
	
	/**
     * Get the localization attributes.
     *
     * @return array
     */
	public function attributes()
	{
		return [
			'id_number' => trans('add_laborer.labels.idnumber')
		];
	}
}
