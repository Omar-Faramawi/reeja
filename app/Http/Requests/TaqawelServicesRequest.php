<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class TaqawelServicesRequest extends Request
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
            'contract_nature_id' => 'required|required_if:new_service,null|'.$this->determineRule(Request::get('contract_nature_id')),
            'new_service'        => 'required_if:contract_nature_id,other',
            'description'        => 'min:3',
        ];
    }
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'contract_nature_id' => trans('taqawoul.form_attributes.service_type'),
            'description'        => trans('taqawoul.form_attributes.service_description'),
            'new_service'        => trans('taqawoul.form_attributes.other'),
        ];
    }


    /**
     * Get Custom Messages for validation errors .
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'new_service.required_if' => trans('taqawoul.form_attributes.othermsg'),
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
