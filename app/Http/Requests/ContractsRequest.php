<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class ContractsRequest extends Request
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
            'id'               => 'required|exists:contracts,id',
            'reason_id'        => 'required|integer|exists:reasons,id',
            'other_reasons'    => 'sometimes|required|max:255',
            'rejection_reason' => 'sometimes|min:0|max:255',
            'status'           => 'required|in:pending,rejected,pending_ownership,approved,cancelled,benef_cancel,provider_cancel',
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
            'id'               => trans('contracts.id'),
            'rejection_reason' => trans('contracts.rejection_reason'),
            'reason_id'        => trans('contracts.reason_id'),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'other_reasons.required' => trans('offersdirect.modal.reject.other_reason'),
        ];
    }
}
