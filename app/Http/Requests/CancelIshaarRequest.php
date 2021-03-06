<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class CancelIshaarRequest extends Request
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
            'reason'        => 'required',
            'report_check'  => 'required|in:1',
            'other'         => 'sometimes|required|max:255',
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
            'reason'        => trans('ishaar_setup.form_attributes.cancel_reason'),
            'report_check'  => trans('contracts.disclaimers'),
            'other'         => trans('contracts.others'),
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
            'other.required' => trans('offersdirect.modal.reject.other_reason'),
            'report_check.*'    => trans('contracts.accept_disclaimers'),
        ];
    }

}
