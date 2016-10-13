<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class ContractCertificateRequest extends Request
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
            "contract_ids"=>"required",
        ];
    }

    public function messages()
    {
        return [
            "contract_ids.required"=>trans("packagesubscribe.shouldChooseContract"),
        ];
    }
}
