<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class PublishServiceRequest extends Request
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
            "contract_nature_id" => "required|not_in:0",
            "description"        => "required"
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'contract_nature_id.not_in' => trans('publishservice.contractIdRequired'),
            'description.required'      => trans('publishservice.descriptionRequired'),
        ];
    }
}
