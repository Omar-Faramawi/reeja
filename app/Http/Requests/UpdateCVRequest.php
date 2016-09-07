<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class UpdateCVRequest extends Request
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
            'job_id'           => 'required|exists:ad_jobs,id',
            'experience_id'    => 'required|exists:experiences,id',
            'qualification_id' => 'required|exists:qualifications,id',
            'region_id'        => 'required|exists:regions,id',
            'job_type'         => 'required|in:0,1',
            'work_start_date'  => 'required|date|before:work_end_date',
            'work_end_date'    => 'required|date|after:work_start_date',
            'chk'              => 'in:0,1',
        ];
    }

    /**
     * Get the validation attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return trans('cv_publishment.attributes');
    }
}
