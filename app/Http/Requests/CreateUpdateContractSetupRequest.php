<?php

namespace Tamkeen\Ajeer\Http\Requests;

/**
 * Class CreateUpdateContractSetupRequest
 * @package Tamkeen\Ajeer\Http\Requests
 */
class CreateUpdateContractSetupRequest extends Request
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
            'contract_type_id'                  => 'required|exists:contract_types,id',
            'offer_accept_period'               => 'sometimes|required|integer|min:1|max:365',
            'min_accept_period'                 => 'integer|min:1|max:365',
            'max_accept_period'                 => 'integer|min:1|max:365',
            'contract_cancel_period'            => 'sometimes|required|integer|min:1|max:365',
            'contract_accept_period'            => 'integer|min:1|max:365',
            'saudi_service_avb'                 => 'boolean',
            'substitute_percintage'             => 'sometimes|integer|min:1|max:100',
            'max_labor_avb'                     => 'sometimes|integer|min:1|max:365',
            'experience_certificate_pay_period' => 'integer|min:1|max:365',
            'experience_certificate_amount'     => 'sometimes|required|integer|min:1|max:999999999',
            'ishaar_cancel_period'              => 'sometimes|required|integer|min:1|max:365',
            'offer_accept_period_type'          => 'in:1,2,3',
            'ishaar_cancel_period_type'         => 'in:1,2,3',
            'min_accept_period_type'            => 'in:1,2,3',
            'max_accept_period_type'            => 'in:1,2,3',
            'contract_accept_period_type'       => 'in:1,2,3',
            'contract_cancel_period_type'       => 'in:1,2,3',
            'provider_cancel_ishaar'            => 'min:1|max:999999999',
            'benf_cancel_ishaar'                => 'min:1|max:999999999',
            'ownership_att_time'                => 'min:1|max:999999999',
            'ownership_att_time_offer'          => 'min:1|max:999999999',
            'benf_cancel_contract'              => 'in:0,1',
            'provider_cancel_contract'          => 'in:0,1'
        ];
    }

    /**
     * Get the attributes names translated
     * @return array
     */
    public function attributes()
    {
        return [
            'contract_type_id'                  => trans('contract_setup.attributes.contract_type_id'),
            'offer_accept_period'               => trans('contract_setup.attributes.offer_accept_period'),
            'max_contract_period'               => trans('contract_setup.attributes.max_contract_period'),
            'contract_cancel_period'            => trans('contract_setup.attributes.contract_cancel_period'),
            'provider_cancel_contract'          => trans('contract_setup.attributes.provider_cancel_contract'),
            'benf_cancel_contract'              => trans('contract_setup.attributes.benf_cancel_contract'),
            'contract_accept_period'            => trans('contract_setup.attributes.contract_accept_period'),
            'Saudi_service_avb'                 => trans('contract_setup.attributes.saudi_service_avb'),
            'substitute_percintage'             => trans('contract_setup.attributes.substitute_percintage'),
            'max_labor_avb'                     => trans('contract_setup.attributes.max_labor_avb'),
            'ownership_att_time'                => trans('contract_setup.attributes.ownership_att_time'),
            'Ownership_att_time_offer'          => trans('contract_setup.attributes.ownership_att_time_offer'),
            'experience_certificate_amount'     => trans('contract_setup.attributes.experience_certificate_amount'),
            'experience_certificate_pay_period' => trans('contract_setup.attributes.exp_certificate_pay_period'),
            'offer_accept_period_type'          => trans('contract_setup.attributes.offer_accept_period_type'),
            'contract_accept_period_type'       => trans('contract_setup.attributes.contract_accept_period_type'),
            'contract_cancel_period_type'       => trans('contract_setup.attributes.contract_cancel_period_type'),
            'ishaar_cancel_period'              => trans('contract_setup.attributes.ishaar_cancel_period'),
            'ishaar_cancel_period_type'         => trans('contract_setup.attributes.min_accept_period'),
            'min_accept_period'                 => trans('contract_setup.attributes.min_accept_period'),
            'max_accept_period'                 => trans('contract_setup.attributes.max_accept_period'),
            'min_accept_period_type'            => trans('contract_setup.attributes.min_accept_period_type'),
            'max_accept_period_type'            => trans('contract_setup.attributes.max_accept_period_type'),
            'provider_cancel_ishaar'            => trans('contract_setup.attributes.provider_cancel_ishaar'),
            'benf_cancel_ishaar'                => trans('contract_setup.attributes.benf_cancel_ishaar'),
        ];
    }
}
