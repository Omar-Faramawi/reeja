<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class LoanPcntRequest extends Request
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
            'percentages.*' => 'required|integer|min:0|max:100',
            
        ];
    }
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'percentages.1' => trans('loan_pcnt.headings1'),
            'percentages.2' => trans('loan_pcnt.headings2'),
            'percentages.3' => trans('loan_pcnt.headings3'),
            'percentages.4' => trans('loan_pcnt.headings4'),
            'percentages.5' => trans('loan_pcnt.headings5'),
        ];
    }
}
