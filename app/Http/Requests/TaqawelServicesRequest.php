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
        if (Request::get('status') == 0) {
            return [];
        } else {
            if(Request::get('service_type') == 'other'){
               return [
                    'status'          => 'numeric',
                    'new_service'     => 'required',
                    'description'     => 'min:3',
                ];

            }else{
            
                return [
                    'service_type'    => 'required',
                    'status'          => 'numeric',
                    'description'     => 'min:3',
                ];
            }
            }
    }
       
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'service_type'       => trans('taqawoul.form_attributes.service_type'),
            'description'        => trans('taqawoul.form_attributes.service_description'),
            'new_service'          => trans('taqawoul.form_attributes.other'),
            
        ];
    }
}
