<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Hashids;

class BundlesRequest extends Request
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
            'min_of_num_ishaar' => "required|numeric|min:1,max:" . PHP_INT_MAX,
            'max_of_num_ishaar' => "required|numeric|min:min_of_num_ishaar,max:" . PHP_INT_MAX,
            'monthly_amount'    => "required|numeric|min:1,max:" . PHP_INT_MAX,
        ];
    }
    
    /**
     * Get the localization attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('bundles.attributes');
    }
    
}
