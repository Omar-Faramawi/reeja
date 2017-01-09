<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class OfferTaqawelRejectRequest extends Request
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
            "reason_id"    => 'required|not_in:0',
            'other_reason' => 'sometimes|required|max:255'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'reason_id.required' => trans('offersdirect.modal.reject.message'),
            'other_reason.required' => trans('offersdirect.modal.reject.other_reason'),
        ];
    }
}
