<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Hashids;

class ReasonsRequest extends Request
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
            "reason"    => "required",
            "parent_id" => "required|in:1,2",
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
            'reason'    => trans('reasons.attributes.reason'),
            'parent_id' => trans('reasons.attributes.parent_id'),
        ];
    }
    
}
