<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Input;
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
        $rules = [
            'contract_type_id'                 => 'exists:contract_types,id',
            'service_prvdr_benf_id'            => 'exists:service_prvdr_benf,id',
            'benf_est'                         => 'required|in:0,1',
            'benf_indv'                        => 'required|in:0,1',
            'benf_gover'                       => 'required|in:0,1',
            'avl_borrow_labor'                 => 'integer|min:0|max:99999999',
            'est_perm_activities.*.loan_pct'   => 'required_if:estIsProvider,1|integer|min:0|max:100',
            'est_perm_activities.*.borrow_pct' => 'required_if:estIsProvider,1|integer|min:0|max:100',
        ];

        if (Input::get('benf_gover')==1 && !$this->in_multi_array('service_users_permission_id',Input::get('gover_activities'))) {
            $rules['gover_activities.*.service_users_permission_id'] = 'required';
        }

        if (Input::get('benf_est')==1 && !$this->in_multi_array_at_least_one(Input::get('est_perm_activities'))) {
            $rules['est_perm_activities.*.provider'] = 'required|in:1';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'benf_indv'                        => trans('service_users_permissions.attributes.benf_indv'),
            'contract_type_id'                 => trans('service_users_permissions.attributes.contract_type_id'),
            'benf_est'                         => trans('service_users_permissions.attributes.benf_est'),
            'service_prvdr_benf_id'            => trans('service_users_permissions.attributes.service_prvdr_benf_id'),
            'benf_gover'                       => trans('service_users_permissions.attributes.benf_gover'),
            'avl_borrow_labor'                 => trans('service_users_permissions.attributes.avl_borrow_labor'),
            'est_perm_activities.*.loan_pct'   => trans('service_users_permissions.attributes.loan_labor_pct'),
            'est_perm_activities.*.borrow_pct' => trans('service_users_permissions.attributes.borrow_labor_pct'),
        ];
    }

    /**
     * Get Custom Messages for validation errors .
     *
     * @return array
     */
    public function messages()
    {
        return [
            'est_perm_activities.*.loan_pct.required_if'   => trans('service_users_permissions.attributes.loan_labor_pct'),
            'est_perm_activities.*.borrow_pct.required_if' => trans('service_users_permissions.attributes.borrow_labor_pct'),
            'gover_activities.*.service_users_permission_id.required'  => trans('service_users_permissions.at_least_one_gover_activities'),
            'est_perm_activities.*.provider.in'  => trans('service_users_permissions.at_least_one_privillage'),
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return array_unique($validator->errors()->all());
    }

    protected function in_multi_array($needle, $haystack)
    {
        if (in_array($needle, $haystack)) {
            return true;
        }
        foreach ($haystack as $element) {
            if (array_key_exists($needle, $element)) {
                return true;
            }
        }
        
        return false;
    }

    protected function in_multi_array_at_least_one($haystack)
    {
        foreach ($haystack as $element) {
            if ($element['provider'] ==0 && $element['benf']==0 && $element['benf_activity'] ==0) {
                return false;
            }
        }

        return true;
    }
}
