<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Tamkeen\Ajeer\Utilities\Constants;

class SearchForJobRequest extends Request
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
            'region_id'       => 'exists:regions,id',
            'job_id'          => 'exists:ad_jobs,id',
            'job_type'        => 'in:0,1',
            'work_start_date' => 'date|before:work_end_date',
            'work_end_date'   => 'date|after:work_start_date',
            'owner_name'      => '',
            'benf_type'       => 'required'
        ];
    }

    /**
     * Get the translated attributes
     */
    /**
     * @return ParameterBag
     */
    public function attributes()
    {
        return trans('labor_market.attributes');
    }
}
