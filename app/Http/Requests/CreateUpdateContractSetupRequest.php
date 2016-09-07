<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

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
            'offer_accept_period'               => 'numeric|min:0|max:365',
            'min_accept_period'                 => 'numeric|min:0|max:365',
            'max_accept_period'                 => 'numeric|min:0|max:365',
            'contract_cancel_period'            => 'numeric|min:0|max:365',
            'provider_cancel_contract'          => 'boolean',
            'benf_cancel_contract'              => 'boolean',
            'contract_accept_period'            => 'numeric|min:0|max:365',
            'saudi_service_avb'                 => 'boolean',
            'substitute_percintage'             => 'numeric|min:0|max:100',
            'max_labor_avb'                     => 'numeric|min:0|max:365',
            'ownership_att_time'                => 'boolean',
            'ownership_att_time_offer'          => 'boolean',
            'experience_certificate_pay_period' => 'numeric|min:0|max:365',
            'experience_certificate_amount'     => 'numeric|min:0|max:999999999',
            'offer_accept_period_type'          => 'in:1,2,3',
            'min_accept_period_type'            => 'in:1,2,3',
            'max_accept_period_type'            => 'in:1,2,3',
            'contract_cancel_period_type'       => 'in:1,2,3',
            'provider_cancel_ishaar'            => 'boolean',
            'benf_cancel_ishaar'                => 'boolean',
        ];
    }

    /**
     * Get the attributes names translated
     * @return array
     */
    public function attributes()
    {
        return [
            'Contract_type_id'                  => trans('contract_setup.attributes.contract_type_id'),
            'Offer_accept_period'               => trans('contract_setup.attributes.offer_accept_period'),
            'Max_contract_period'               => trans('contract_setup.attributes.max_contract_period'),
            'Contract_cancel_period'            => trans('contract_setup.attributes.contract_cancel_period'),
            'Provider_cancel_contract'          => trans('contract_setup.attributes.provider_cancel_contract'),
            'Benf_cancel_contract'              => trans('contract_setup.attributes.benf_cancel_contract'),
            'Contract_accept_period'            => trans('contract_setup.attributes.contract_accept_period'),
            'Saudi_service_avb'                 => trans('contract_setup.attributes.saudi_service_avb'),
            'Substitute_percentage_int'         => trans('contract_setup.attributes.substitute_percentage_int'),
            'Max_labor_avb'                     => trans('contract_setup.attributes.max_labor_avb'),
            'ownership_att_time'             => trans('contract_setup.attributes.ownership_att_time'),
            'Ownership_att_time_offer'          => trans('contract_setup.attributes.ownership_att_time_offer'),
            'experience_certificate_amount'     => trans('contract_setup.attributes.exp_certificate_amount'),
            'experience_certificate_pay_period' => trans('contract_setup.attributes.exp_certificate_pay_period'),
            'Provider_cancel_contract'          => trans('contract_setup.attributes.provider_cancel_ishaar'),
            'Benf_cancel_contract'              => trans('contract_setup.attributes.benf_cancel_ishaar'),
        ];
    }
}
