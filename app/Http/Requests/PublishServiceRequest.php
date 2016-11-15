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
            "new_service"        => "required_if:contract_nature_id,other|unique:contract_nature,name,0,id,deleted_at,NULL",
            "description"        => "required|min:3|max:255"
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'contract_nature_id.*' => trans('publishservice.contractIdRequired'),
            'description.required' => trans('publishservice.descriptionRequired'),
            'new_service.required_if' => trans('taqawoul.form_attributes.othermsg'),
            'new_service.unique'   => trans('publishservice.duplicatedService')
        ];
    }

    /**
     * check if contract nature id n't equal other we must check
     * if exists in table or n't
     *
     * @param contract_nature_id
     *
     * @return string
     */
    protected function determineRule($contract_nature_id)
    {
        return ($contract_nature_id == 'other') ? '' : 'exists:contract_nature,id';
    }
}
