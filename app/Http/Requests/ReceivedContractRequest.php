<?php

namespace Tamkeen\Ajeer\Http\Requests;


class ReceivedContractRequest extends Request
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
            'start_date'                 => 'date|required',
            'end_date'                   => 'date|required|after:start_date',
            'region_id.*'                => 'required|integer',
            'contract_locations'         => 'required',
            'contract_file'              => 'file|mimes:doc,docx,pdf'
        ];
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
            'region_id.*'                             => trans('temp_job.region_id'),
            'contract_locations'                      => trans('temp_job.contract_locations'),
            'contract_file'                           => trans('temp_job.attachment'),
        ];
    }
}
