<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class OfferRejectRequest extends Request
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
            "reason_id"    => 'required',
            'other_reason' => 'required_if:reason_id,14|min:0|max:255'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'reason_id.required'       => trans('offers.modal.reject.message'),
            'other_reason.required_if' => trans('offersdirect.modal.reject.other_reason'),
        ];
    }
}
