<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Illuminate\Support\Facades\Input;
use Tamkeen\Ajeer\Http\Requests\Request;

class ContractMembersTaqyeemRequest extends Request
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
            'link_period'         => 'required',
            'taqyeem_template_id' => 'required',
            'taqyeem_type'        => 'required',
            'portal_services'     => 'required_if:taqyeem_type,1',
            'periodic_period'     => 'required_if:periodic_or_date,1',
            'taqyeem_date'        => 'required_if:periodic_or_date,2',
            'userTypeResidents'        => 'required_if:residents,1',
        ];
        if (is_array(Input::get('portal_services'))) {
            if (in_array('taqawel_services', Input::get('portal_services'))) {
                $rules['taqawel_services'] = 'required';
            }
            if (in_array('hire_labore', Input::get('portal_services'))) {
                $rules['hire_labore'] = 'required';
            }
            if (in_array('direct_emp', Input::get('portal_services'))) {
                $rules['direct_emp'] = 'required';
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'link_period.required'        => trans('contractmembertaqyeem.link_period_required'),
            'taqyeem_type.required'       => trans('contractmembertaqyeem.taqyeem_type_required'),
            'portal_services.required_if'    => trans('contractmembertaqyeem.portal_services_required'),
            'taqawel_services.required'   => trans('contractmembertaqyeem.taqawel_services_required'),
            'hire_labore.required'        => trans('contractmembertaqyeem.hire_labore_required'),
            'direct_emp.required'         => trans('contractmembertaqyeem.direct_emp_required'),
            'periodic_period.required_if' => trans('contractmembertaqyeem.periodic_period_required_if'),
            'taqyeem_date.required_if'    => trans('contractmembertaqyeem.taqyeem_date_required_if'),
            'userTypeResidents.required_if'    => trans('contractmembertaqyeem.userTypeResidents_if'),
        ];
    }
}
