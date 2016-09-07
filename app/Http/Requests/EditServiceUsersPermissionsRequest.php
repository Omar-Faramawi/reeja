<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class EditServiceUsersPermissionsRequest extends Request
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
            'contract_type_id'      => 'exists:contract_types,id',
            'service_prvdr_benf_id' => 'exists:service_prvdr_benf,id',
            'benf_est'              => 'required|in:0,1',
            'benf_indv'             => 'required|in:0,1',
            'benf_gover'            => 'required|in:0,1',
            'avl_borrow_labor'      => 'numeric|min:0|max:99999999'
        ];
    }

    public function attributes()
    {
        return [
            'benf_indv'             => trans('service_users_permissions.attributes.benf_indv'),
            'contract_type_id'      => trans('service_users_permissions.attributes.contract_type_id'),
            'benf_est'              => trans('service_users_permissions.attributes.benf_est'),
            'service_prvdr_benf_id' => trans('service_users_permissions.attributes.service_prvdr_benf_id'),
            'benf_gover'            => trans('service_users_permissions.attributes.benf_gover'),
            'avl_borrow_labor'      => trans('service_users_permissions.attributes.avl_borrow_labor')
        ];
    }
}
