<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

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
        if (Request::get('tab') == 'general') {
            $rules = [
                'labor_status_employed'      => 'required_without_all:labor_status_companion,labor_status_visitor|in:0,1',
                'labor_status_companion'     => 'required_without_all:labor_status_employed,labor_status_visitor|in:0,1',
                'labor_status_visitor'       => 'required_without_all:labor_status_employed,labor_status_companion|in:0,1',
                'labor_gender_male'          => 'required_without:labor_gender_female|in:0,1',
                'labor_gender_female'        => 'required_without:labor_gender_male|in:0,1',
                'ishaar_cancel_free'         => 'sometimes|required_without:ishaar_cancel_paid|in:0,1',
                'ishaar_cancel_paid'         => 'sometimes|required_without:ishaar_cancel_free|in:0,1',
                'ishaar_cancel_provider'     => 'in:0,1',
                'ishaar_cancel_benf'         => 'in:0,1',
                'nitaq_active'               => 'required|in:0,1',
            ];
        } else {
            $rules = [
                'max_ishaar_period'          => 'integer|required|min:1|max:365|greater_than:min_ishaar_period,min_ishaar_period_type,max_ishaar_period_type',
                'max_ishaar_period_type'     => 'required|in:1,2,3',
                'total_period_labor'         => 'required|integer|min:1|max:1000000',
            ];
            
            if (Request::get('tab') == 'free') {
                $rules['max_no_of_ishaars'] = 'required|integer|min:1|max:1000000';
                $rules['ishaar_lobor_times'] = 'required|integer|min:1|max:1000000';
            } elseif (Request::get('tab') == 'paid') {
                $rules['min_ishaar_period']                          = 'required|integer|min:1|max:365';
                $rules['min_ishaar_period_type']                     ='required|in:1,2,3';
                $rules['labor_follow_provider_perm']                 = 'in:0,1';
                $rules['labor_follow_benef_perm']                    = 'in:0,1';
                $rules['labor_follow_all_perm']                      = 'in:0,1';
                $rules['trial_ishaar_num']                           = 'required|integer|min:1|max:1000000';
                $rules['paid_ishaar_payment_expiry_period']          = 'required|integer|min:1|max:365';
                $rules['paid_ishaar_payment_expiry_period_type']     = 'required|in:1,2,3';
                $rules['paid_ishaar_valid_expiry_period']            = 'required|integer|min:1|max:365';
                $rules['paid_ishaar_valid_expiry_period_type']       = 'required|in:1,2,3';
                $rules['labor_multi_regions_perm']                   = 'required|in:0,1';
                $rules['labor_multi_regions_perm_num']               = 'required|integer|min:1|max:1000000';
                $rules['labor_same_benef_max_num_of_ishaar']         = 'required_without:labor_same_benef_max_period_of_ishaar|integer|min:1|max:1000000';
                $rules['labor_same_benef_max_period_of_ishaar']      = 'required_without:labor_same_benef_max_num_of_ishaar|integer|min:1|max:365';
                $rules['labor_same_benef_max_period_of_ishaar_type'] = 'required|in:1,2,3';
            }
        }

        return $rules;
    }
    
    /**
     * Get Translated attributes
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public function attributes()
    {
        return trans('ishaar_setup.attributes');
    }

    public function messages()
    {
        return [
            'max_ishaar_period.greater_than'                         => trans('ishaar_setup.max_ishaar_period_greater_than'),
            'max_no_of_ishaars.greater_than'                         => trans('ishaar_setup.max_no_of_ishaars_greater_than'),
            'labor_status_employed.required_without_all'             => trans('ishaar_setup.attributes.choose').' '.trans('ishaar_setup.attributes.labor_status'),
            'labor_status_companion.required_without_all'            => trans('ishaar_setup.attributes.choose').' '.trans('ishaar_setup.attributes.labor_status'),
            'labor_status_visitor.required_without_all'              => trans('ishaar_setup.attributes.choose').' '.trans('ishaar_setup.attributes.labor_status'),
            'labor_gender_male.required_without'                     => trans('ishaar_setup.attributes.choose').' '.trans('ishaar_setup.form_attributes.labor_gender'),
            'labor_gender_female.required_without'                   => trans('ishaar_setup.attributes.choose').' '.trans('ishaar_setup.form_attributes.labor_gender'),
            'ishaar_cancel_free.required_without'                    => trans('ishaar_setup.attributes.choose').' '.trans('ishaar_setup.form_attributes.ishaar_cancel_type'),
            'ishaar_cancel_paid.required_without'                    => trans('ishaar_setup.attributes.choose').' '.trans('ishaar_setup.form_attributes.ishaar_cancel_type'),
            'ishaar_cancel_provider.required_without'                => trans('ishaar_setup.attributes.choose').' '.trans('ishaar_setup.form_attributes.ishaar_cancel_permission'),
            'ishaar_cancel_benf.required_without'                    => trans('ishaar_setup.attributes.choose').' '.trans('ishaar_setup.form_attributes.ishaar_cancel_permission'),
            'labor_same_benef_max_num_of_ishaar.required_without'    => trans('ishaar_setup.attributes.labor_same_benef_not_choosen'),
            'labor_same_benef_max_period_of_ishaar.required_without' => trans('ishaar_setup.attributes.labor_same_benef_not_choosen'),
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return array_unique($validator->errors()->all());
    }
}
