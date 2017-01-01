<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class TaqawelGetContractsRequest extends Request
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
            "contract_nature_id" => "required|exists:contracts,contract_nature_id"
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
//            'labour_office_no' => trans('establishments_registration.attributes.labour_office_no'),
        ];
    }

}
