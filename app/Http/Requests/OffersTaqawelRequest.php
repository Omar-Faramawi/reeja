<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class OffersTaqawelRequest extends Request
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
            "agree" => "required",
        ];
    }

    /*
 *
 *
 */

    public function messages()
    {
        return [
            "agree.required" => trans("offersdirect.modal.accept.message"),
        ];
    }
}
