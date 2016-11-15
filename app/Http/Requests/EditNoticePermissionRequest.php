<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

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
        return [
            'ishaar_issue_est'   => 'sometimes|required|in:0,1',
            'ishaar_issue_gover' => 'sometimes|required|in:0,1',
            'ishaar_issue_indv'  => 'sometimes|required|in:0,1',
            'ishaar_benf_est'    => 'sometimes|required|in:0,1',
            'ishaar_benf_indv'   => 'sometimes|required|in:0,1',
            'ishaar_benf_gover'  => 'sometimes|required|in:0,1',
            'labor_borrow_count' => 'integer|min:0|max:99999999',
        ];
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
}
