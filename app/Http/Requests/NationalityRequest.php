<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Hashids;

class NationalityRequest extends Request
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
        $id = $this->getTargetId(4);

        return [
            'name'    => 'required|min:3|max:45|unique:nationalities,name,' . $id . ',id,deleted_at,NULL',
            'eng_name' => 'required|min:3|max:45|unique:nationalities,eng_name,' . $id . ',id,deleted_at,NULL',
            'abbr' => 'required|min:2|max:3|unique:nationalities,abbr,' . $id . ',id,deleted_at,NULL',
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
			'name' => trans('nationalities.attributes.ar-name'),
			'eng_name' => trans('nationalities.attributes.en-name'),
			'abbr' => trans('nationalities.attributes.abbr-name'),
		];
	}
}
