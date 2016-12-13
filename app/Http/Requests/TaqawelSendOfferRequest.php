<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Tamkeen\Ajeer\Utilities\Constants;

class TaqawelSendOfferRequest extends Request
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
        if($this->method == 'PUT')
        {
            return [
                'contract_id'        => 'sometimes|integer|exists:contracts,id',
                'contract_name'      => 'sometimes|required|min:2|max:120|contract_field_cannot_edit_if_approved:' . $this->request->get('contract_id'),
                'contract_desc'      => 'sometimes|required|min:2|max:225|contract_field_cannot_edit_if_approved:' . $this->request->get('contract_id'),
                'contract_amount'    => 'sometimes|required|integer|contract_field_cannot_edit_if_approved:' . $this->request->get('contract_id'),
                'start_date'         => 'sometimes|required|date|contract_field_cannot_edit_if_approved:' . $this->request->get('contract_id'),
                'end_date'           => 'sometimes|required|after:start_date|after:'.date('Y-m-d').'|contract_field_cannot_edit_if_approved:' . $this->request->get('contract_id'),
                'contract_ref_no'    => 'required_if:contract_type,1|integer|contract_field_cannot_edit_if_approved:' . $this->request->get('contract_id'),
                'desc_location.*'    => 'sometimes|required|min:3',
                'file_contract'      => 'required_without:file_contract_old|mimes:jpeg,bmp,png,doc,docx,pdf|max:20000',
                'status'             => 'sometimes|required|in:pending,approved',
            ];
        } else {
            return [
                'contract_name'      => 'required|min:2|max:120',
                'contract_desc'      => 'required|min:2|max:225',
                'contract_amount'    => 'required|integer',
                'start_date'         => 'required|date',
                'end_date'           => 'required|after:start_date|after:'.date('Y-m-d'),
                'contract_ref_no'    => 'required_if:contract_type,1|integer',
                'desc_location.*'    => 'required',
                'desc_location'      => 'required',
                'file_contract'      => 'required|mimes:jpeg,bmp,png,doc,docx,pdf|max:20000',
                'status'             => 'sometimes|required|in:pending,approved',
            ];
        }

    }

    /**
     * Get the localization attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'contract_name'      => trans('tqawel_offer_contract.contract_name'),
            'contract_desc'      => trans('tqawel_offer_contract.contract_desc'),
            'contract_amount'    => trans('tqawel_offer_contract.contract_amount'),
            'start_date'         => trans('tqawel_offer_contract.start_date'),
            'end_date'           => trans('tqawel_offer_contract.end_date'),
            'contract_ref_no'    => trans('tqawel_offer_contract.contract_ref_no'),
            'desc_location'      => trans('tqawel_offer_contract.work_locations'),
            'file_contract'      => trans('tqawel_offer_contract.attached_file'),
            'contract_type'      => trans('tqawel_offer_contract.contract_type'),
        ];
    }

    public function messages()
    {
        return [
            'file_contract.required_without' => trans('validation.required')
        ];
    }
}
