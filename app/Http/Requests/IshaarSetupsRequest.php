<?php

namespace Tamkeen\Ajeer\Http\Requests;

/**
 * Class IshaarSetupsRequest
 * @package Tamkeen\Ajeer\Http\Requests
 */
class IshaarSetupsRequest extends Request
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
            'name'                                       => 'required|min:3|max:255',
            'ishaar_type_id'                             => 'required|in:3',
            'min_ishaar_period'                          => 'required|integer|min:0|max:365',
            'max_ishaar_period'                          => 'required|integer|min:0|max:365',
            'amount'                                     => 'required|integer',
            'payment_period'                             => 'required|integer|min:0',
            'issued_season'                              => 'required|integer',
            'period_start_date'                          => 'required_if:issued_season,0|date',
            'period_end_date'                            => 'required_if:issued_season,0|date|after:period_start_date',
            'regions'                                    => 'required',
            'max_labor_from_haj'                         => 'min:0|max:50',
            'nitaq_active'                               => 'required|in:0,1',
            'nitaq_haj'                                  => 'required_if:regions,max_labor_from_haj|in:1',
            'nitaq_gover'                                => 'required_if:regions,max_labor_from_haj|in:1',
            'labor_status_employed'                      => 'in:0,1',
            'labor_status_companion'                     => 'in:0,1',
            'labor_status_visitor'                       => 'in:0,1',
            'job'                                        => 'required',
            'nationalities.*'                            => 'required',
            'labor_gender_male'                          => 'in:0,1',
            'labor_gender_female'                        => 'in:0,1',
            'max_of_notice_renew_time'                   => 'sometimes|required|integer|min:1|max:' . PHP_INT_MAX,
            'labor_same_benef_max_period_of_ishaar_type' => 'sometimes|required|integer|min:1|max:' . PHP_INT_MAX,
        ];
    }
    
    /**
     * Get the attributes names translated
     * @return array
     */
    public function attributes()
    {
        return [
            'name'                                       => trans('ishaar_setup.attributes.ishaar_name'),
            'ishaar_type_id'                             => trans('ishaar_setup.attributes.ishaar_type_id'),
            'min_ishaar_period'                          => trans('ishaar_setup.attributes.min_ishaar_period'),
            'max_ishaar_period'                          => trans('ishaar_setup.attributes.max_ishaar_period'),
            'amount'                                     => trans('ishaar_setup.attributes.amount'),
            'payment_period'                             => trans('ishaar_setup.attributes.payment_period'),
            'issued_season'                              => trans('ishaar_setup.attributes.issued_season'),
            'period_start_date'                          => trans('ishaar_setup.attributes.period_start_date'),
            'period_end_date'                            => trans('ishaar_setup.attributes.period_end_date'),
            'regions'                                    => trans('ishaar_setup.attributes.regions'),
            'region_name'                                => trans('ishaar_setup.attribte.region_name'),
            'max_labor_from_haj'                         => trans('ishaar_setup.attributes.max_labor_from_haj'),
            'nitaq_active'                               => trans('ishaar_setup.attributes.nitaq_active'),
            'job'                                        => trans('ishaar_setup.attributes.job'),
            'nationalities.0'                            => trans('ishaar_setup.attributes.nationalities'),
            'labor_gender_male'                          => trans('ishaar_setup.gender.0'),
            'labor_gender_female'                        => trans('ishaar_setup.gender.1'),
            'max_of_notice_renew_time'                   => trans('ishaar_setup.attributes.max_of_notice_renew_time'),
            'labor_same_benef_max_period_of_ishaar_type' => trans('ishaar_setup.attributes.labor_same_benef_max_period_of_ishaar_type'),
        ];
    }
}
