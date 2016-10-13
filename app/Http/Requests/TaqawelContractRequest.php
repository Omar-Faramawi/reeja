<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class TaqawelContractRequest extends Request
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
            'reason' => 'required',
            'other'        => 'required_if:reason,other',
            'details'        => 'min:3',
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
            'other' => trans('contracts.rejection_reason'),
            'reason'        => trans('contracts.reason_id'),
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
            'other.required_if' => trans('offersdirect.modal.reject.other_reason'),
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
