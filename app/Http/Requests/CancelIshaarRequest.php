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
            'other'         => 'required_if:reason,other|min:0|max:255',
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
            'other' => trans('contracts.others'),
            'reason'        => trans('contracts.reason_id'),
        ];
    }
}
