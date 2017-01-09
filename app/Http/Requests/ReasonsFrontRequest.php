<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class ReasonsFrontRequest extends Request
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
            'id'               => 'required',
            'reason_id'        => 'required',
            'other_reason'     => 'sometimes|required|max:255',
            'details'          => 'sometimes|min:0|max:255',
            'status'           => 'sometimes|required|in:pending,rejected,pending_ownership,approved,cancelled,benef_cancel,provider_cancel',
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
            'details'          => trans('contracts.rejection_reason'),
            'reason_id'        => trans('contracts.reason_label'),
            'other_reason'     => trans('contracts.other_reason_label'),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'reason_id.required'    => trans('contracts.reason_required'),
            'other_reason.required' => trans('contracts.other_reason_required'),
        ];
    }
}
