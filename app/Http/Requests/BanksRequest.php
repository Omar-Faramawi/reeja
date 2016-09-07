<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Hashids;

class BanksRequest extends Request
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
            "name"           => "required|unique:banks,name," . $id . ',id,deleted_at,NULL',
            "type"           => "required|boolean",
            "parent_bank_id" => "required_if:type,0|not_in:".$id
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
			'parent_bank_id' => trans('banks.attributes.parent_bank_id'),
			'type'           => trans('banks.attributes.type')
		];
	}

}
