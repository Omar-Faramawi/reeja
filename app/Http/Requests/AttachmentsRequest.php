<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Hashids;

class AttachmentsRequest extends Request
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
            'name'    => 'required|min:3|max:45|unique:attachments,name,' . $id . ',id,deleted_at,NULL'
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
			'name' => trans('attachments.attributes.ar-name')
		];
	}
}
