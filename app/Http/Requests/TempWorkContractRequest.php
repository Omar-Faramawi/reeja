<?php

namespace Tamkeen\Ajeer\Http\Requests;


class TempWorkContractRequest extends Request
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
    	if( $this->request->get('old_status') === 'approved') {
		    return [
			    'contract_locations'         => 'required',
			    'contract_file'              => 'file|mimes:doc,docx,pdf'
		    ];
	    } else {
		    return [
			    'start_date'                 => 'date|required',
			    'end_date'                   => 'date|required|after:start_date',
			    'ids.*'                      => 'required|integer',
			    'contract_locations'         => 'required',
			    'contract_file'              => 'file|mimes:doc,docx,pdf',
			    'job_type'                   => 'required|integer',
		    ];
	    }

    }

    /**
     * Get the localization attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'start_date'                              => trans('temp_job.work_start_date'),
            'end_date'                                => trans('temp_job.work_end_date'),
            'ids.*'                                   => trans('temp_job.registered_employee'),
            'contract_locations'                      => trans('temp_job.contract_locations'),
            'contract_file'                           => trans('temp_job.attachment'),
            'job_type'                                => trans('temp_job.job_type.name'),
        ];
    }
}
