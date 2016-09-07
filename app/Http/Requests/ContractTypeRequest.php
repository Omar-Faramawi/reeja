<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class ContractTypeRequest extends Request
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
        // For get the ID of editing
        $id = $this->getTargetId(3);

        return [
            "name" => "required|unique:contract_types,name," . $id . ',id,deleted_at,NULL'
        ];
    }
}
