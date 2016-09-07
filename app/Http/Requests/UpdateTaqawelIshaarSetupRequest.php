<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class UpdateTaqawelIshaarSetupRequest extends Request
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
        $rules = [
            'labor_gender_male'          => 'required|sometimes|in:0,1',
            'labor_gender_female'        => 'required|sometimes|in:0,1',
            'ishaar_cancel_free'         => 'sometimes|required|in:0,1',
            'ishaar_cancel_paid'         => 'sometimes|required|in:0,1',
            'ishaar_cancel_provider'     => 'sometimes|required|in:0,1',
            'ishaar_cancel_benf'         => 'sometimes|required|in:0,1',
            'nitaq_active'               => 'sometimes|required|in:0,1',
            'total_period_labor'         => 'sometimes|required|min:1|max:1000000',
            'ishaar_lobor_times'         => 'sometimes|required|min:1|max:1000000',
            'min_no_of_ishaars'          => 'sometimes|required|min:0|max:1000000',
            'max_no_of_ishaars'          => 'sometimes|required|min:0|max:1000000',
            'max_ishaar_period'          => 'sometimes|required|min:1|max:100000',
            'max_ishaar_period_type'     => 'sometimes|required|in:1,2,3',
            'min_ishaar_period'          => 'sometimes|required|min:1|max:100000',
            'min_ishaar_period_type'     => 'sometimes|required|in:1,2,3',
            'labor_status_employed'      => 'in:0,1',
            'labor_status_companion'     => 'in:0,1',
            'labor_status_visitor'       => 'in:0,1',
            'labor_follow_provider_perm' => 'in:0,1',
            'labor_follow_benef_perm'    => 'in:0,1',
            'labor_follow_all_perm'      => 'in:0,1',
            
            'trial_ishaar_num'                           => 'required|min:1|max:1000000',
            'paid_ishaar_payment_expiry_period'          => 'required|min:1|max:1000000',
            'paid_ishaar_payment_expiry_period_type'     => 'required|in:1,2,3',
            'paid_ishaar_valid_expiry_period'            => 'required|min:1|max:1000000',
            'paid_ishaar_valid_expiry_period_type'       => 'required|in:1,2,3',
            'labor_multi_regions_perm'                   => 'required|in:0,1',
            'labor_multi_regions_perm_num'               => 'required|min:1|max:1000000',
            'labor_same_benef_max_num_of_ishaar'         => 'required_if:labor_same_benef_max_period_of_ishaar,null|min:1|max:1000000',
            'labor_same_benef_max_period_of_ishaar'      => 'required_if:labor_same_benef_max_num_of_ishaar,null|min:1|max:1000000',
            'labor_same_benef_max_period_of_ishaar_type' => 'required|in:1,2,3',
        ];
        
        return array_intersect_key($rules, request()->all());
    }
    
    /**
     * Get Translated attributes
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function attributes()
    {
        return trans('ishaar_setup.attributes');
    }
}
