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
            'benf_id'                    => 'sometimes|required',
            'benf_type'                  => 'sometimes|required',
            'provider_id'                => 'sometimes|required',
            'provider_type'              => 'sometimes|required',
            'start_date'                 => 'date|required',
            'end_date'                   => 'date|required|after:start_date',
            'region_id.*'                => 'required|numeric',
            'contract_type_id'           => 'numeric',
            'contract_nature_id'         => 'numeric',
            'reason_id'                  => 'numeric',
            'job_request_id'             => 'numeric',
            'market_taqaual_services_id' => 'numeric',
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
            'start_date'                             => trans('temp_job.work_start_date'),
            'end_date'                               => trans('temp_job.work_end_date'),
            'region_id.*'                            => trans('temp_job.region_id'),
            'nationality_id'                         => trans('temp_job.nationality_id'),
            'contract_field_cannot_edit_if_approved' => trans('contracts.contract_field_cannot_edit_if_approved'),
        ];
    }
}
