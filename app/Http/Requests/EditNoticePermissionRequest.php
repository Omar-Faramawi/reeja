<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Input;

class EditNoticePermissionRequest extends Request
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
        $rules =[
            'ishaar_issue_est'   => 'sometimes|required|in:0,1',
            'ishaar_issue_gover' => 'sometimes|required|in:0,1',
            'ishaar_issue_indv'  => 'sometimes|required|in:0,1',
            'ishaar_benf_est'    => 'sometimes|required|in:0,1',
            'ishaar_benf_indv'   => 'sometimes|required|in:0,1',
            'ishaar_benf_gover'  => 'sometimes|required|in:0,1',
            'labor_borrow_count' => 'integer|min:0|max:99999999',
        ];
        if(Input::get('ishaar_benf_est') ==1){
            $rules['est_perm_activities.*.loan_pct'] = 'required_if:est_perm_activities.*.provider,1|integer|min:1|max:100';
            $rules['est_perm_activities.*.borrow_pct'] = 'required_if:est_perm_activities.*.benf,1|required_if:est_perm_activities.*.benf_activity,1|integer|min:1|max:100';

        }
        if (Input::get('est_perm_activities.*.loan_pct')) {
            foreach (Input::get('est_perm_activities.*.loan_pct') as $key => $value) {
                if ($value > 0) {
                    $rules['est_perm_activities.'.$key.'.provider'] = 'required|in:1';
                }
            }
        }
        if(Input::get('est_perm_activities.*.borrow_pct')){
            foreach (Input::get('est_perm_activities.*.borrow_pct') as $key=>$value){
                if($value >0 && Input::get('est_perm_activities.'.$key.'.benf_activity') == 0){
                    $rules['est_perm_activities.'.$key.'.benf'] = 'required|in:1';
                }
            }
        }
        return $rules;
    }
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {

        return trans('ishaar_permissions.attributes');
    }
    /**
     * Get Custom Messages for validation errors .
     *
     * @return array
     */
    public function messages()
    {
        $messages =[
            'gover_activities.*.service_users_permission_id.required'  => trans('service_users_permissions.at_least_one_gover_activities'),
            'est_perm_activities.*.provider'  => trans('service_users_permissions.at_least_one_privillage'),
        ];
        foreach (Input::get('est_perm_activities.*.loan_pct') as $key => $val) {
            $messages['est_perm_activities.'.$key.'.loan_pct.required_if'] = trans('service_users_permissions.attributes.loan_labor_pct',
                ['activity_name' => Input::get('activities.'.$key.'.activity_name')]);
            $messages['est_perm_activities.'.$key.'.provider.in'] = trans('service_users_permissions.attributes.choose_provider',
                ['activity_name' => Input::get('activities.'.$key.'.activity_name')]);
        }
        foreach (Input::get('est_perm_activities.*.borrow_pct') as $key => $val) {
            $messages['est_perm_activities.'.$key.'.borrow_pct.required_if'] = trans('service_users_permissions.attributes.borrow_labor_pct',
                ['activity_name' => Input::get('activities.'.$key.'.activity_name')]);
            $messages['est_perm_activities.'.$key.'.benf.in'] = trans('service_users_permissions.attributes.choose_benf',
                ['activity_name' => Input::get('activities.'.$key.'.activity_name')]);
        }
        return $messages;
    }

    protected function formatErrors(Validator $validator)
    {
        return array_unique($validator->errors()->all());
    }
 
}
