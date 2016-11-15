<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

/**
 * Class CreateUpdateContractSetupRequest
 * @package Tamkeen\Ajeer\Http\Requests
 */
class CreateUpdateTaqawelContractSetupRequest extends Request
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
            'offer_accept_period'               => 'required|integer|min:1|max:365',
            'min_accept_period'                 => 'required|integer|min:1|max:365',
            'max_accept_period'                 => 'required|integer|min:1|max:365|greater_than:min_accept_period,min_accept_period_type,max_accept_period_type',
            'contract_cancel_period'            => 'required|integer|min:1|max:365',
            'contract_accept_period'            => 'required|integer|min:1|max:365',
            'offer_accept_period_type'          => 'required|in:1,2,3',
            'min_accept_period_type'            => 'required|in:1,2,3',
            'max_accept_period_type'            => 'required|in:1,2,3',
            'contract_accept_period_type'       => 'required|in:1,2,3',
            'contract_cancel_period_type'       => 'required|in:1,2,3',
            'provider_cancel_contract'          => 'required_without:benf_cancel_contract|in:0,1',
            'benf_cancel_contract'              => 'required_without:provider_cancel_contract|in:0,1',
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
            'contract_accept_period'            => trans('contract_setup.attributes.tqawel_service_valid_for'),
            'contract_cancel_period'            => trans('contract_setup.attributes.contract_cancel_period'),
            'offer_accept_period'               => trans('contract_setup.attributes.offer_accept_period'),
            'offer_accept_period_type'          => trans('contract_setup.attributes.offer_accept_period_type'),
            'contract_accept_period_type'       => trans('contract_setup.attributes.contract_accept_period_type'),
            'contract_cancel_period_type'       => trans('contract_setup.attributes.contract_cancel_period_type'),
            'min_accept_period'                 => trans('contract_setup.attributes.min_accept_period'),
            'max_accept_period'                 => trans('contract_setup.attributes.max_accept_period'),
            'min_accept_period_type'            => trans('contract_setup.attributes.min_accept_period_type'),
            'max_accept_period_type'            => trans('contract_setup.attributes.max_accept_period_type'),
            'provider_cancel_contract'          => trans('contract_setup.attributes.provider_cancel_contract'),
            'benf_cancel_contract'              => trans('contract_setup.attributes.benf_cancel_contract'),
        ];
    }

    public function messages()
    {
        return [
            'max_accept_period.greater_than'            => trans('contract_setup.attributes.max_accept_period_greater_than'),
            'provider_cancel_contract.required_without' => trans('contract_setup.choose').' '.trans('contract_setup.cancel_acc'),
            'benf_cancel_contract.required_without'     => trans('contract_setup.choose').' '.trans('contract_setup.cancel_acc')
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return array_unique($validator->errors()->all());
    }
}
