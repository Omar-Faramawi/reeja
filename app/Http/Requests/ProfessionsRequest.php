<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class ProfessionsRequest extends Request
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
            'saudi.*'     => 'int:0,1',
            'non_saudi.*' => 'int:0,1',
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
            'job_name'  => trans('professions.attributes.job_name'),
            'saudi'     => trans('professions.attributes.saudi'),
            'non_saudi' => trans('professions.attributes.non_saudi'),
        ];
    }
}
