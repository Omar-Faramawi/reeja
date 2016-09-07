<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Hashids;

class QualificationsRequest extends Request
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
            'name'    => 'required|min:3|max:45|unique:qualifications,name,' . $id . ',id,deleted_at,NULL'
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
			'name' => trans('qualifications.attributes.ar-name')
		];
	}
}
