<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class TaqawelNoticesRequest extends Request
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
                    'start_date'    => 'required|date|before:end_date',
                    'end_date'          => 'required|date|after:start_date',
                    'work_areas'          => 'required',
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
            'start_date'       => trans('ishaar_setup.attributes.ishaar_start_date'),
            'end_date'        => trans('ishaar_setup.attributes.ishaar_end_date'),
            'work_areas'        => trans('ishaar_setup.form_attributes.work_areas'),

        ];
    }
}
