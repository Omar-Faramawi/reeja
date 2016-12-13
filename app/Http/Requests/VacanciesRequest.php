<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class VacanciesRequest extends Request
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
        $value = 'integer';
        //custom rule for salary based on job type
        if (Request::get('job_type')) {
            $value = $this->checkField(Request::get('job_type'));
        }

        if (Request::get('region_id') == 1) {
            return [
                'job_id'          => 'required|integer',
                'religion'        => 'required',
                'region_id'       => 'required',
                'nationality_id'  => 'required',
                'work_start_date' => 'required|date|before:work_end_date',
                'work_end_date'   => 'required|date|after:work_start_date',
            ];

        } else {

            return [
                'job_id'          => 'required|integer',
                'no_of_vacancies' => 'required|integer',
                'gender'          => 'required',
                'religion'        => 'required',
                'region_id'       => 'required',
                'nationality_id'  => 'required',
                'salary'          => $value,
                'work_start_date' => 'required|date|before:work_end_date',
                'work_end_date'   => 'required|date|after:work_start_date',
                'job_type'        => 'integer',
                'hide_salary'     => 'integer',
            ];
        }
    }
    
    /**
     * @param $job_type
     *
     * @return string
     */
    protected function checkField($job_type)
    {
        return ($job_type === '1') ? 'required|integer' : 'integer';
    }
    
    /**
     * Get custom attributes for validator errors.
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'work_type'       => trans('vacancies.form_attributes.region_id'),
            'religion'        => trans('vacancies.form_attributes.religion'),
            'salary'          => trans('vacancies.form_attributes.salary'),
            'no_of_vacancies' => trans('vacancies.form_attributes.required_number'),
            'work_start_date' => trans('vacancies.form_attributes.work_start_date'),
            'work_end_date'   => trans('vacancies.form_attributes.work_end_date'),
            'job_id'          => trans('vacancies.form_attributes.job'),
            'nationality_id'  => trans('vacancies.form_attributes.nationality'),
            'region_id'       => trans('vacancies.form_attributes.region_id'),
        ];
    }
}
