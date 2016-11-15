<?php

namespace Tamkeen\Ajeer\Http\Requests;

class SaudiPercentageRequest extends Request
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
            'provider_activity_id' => 'required|integer',
            'benf_activity_id'     => 'required|integer',
            'provider_size_id'     => 'required|integer',
            'benf_size_id'         => 'required|integer',
            'saudi_pct'            => 'required|integer|min:0|max:100|saudi_percentage_unique:provider_activity_id,' . $this->request->get('provider_activity_id') . ',benf_activity_id,' . $this->request->get('benf_activity_id') . ',provider_size_id,' . $this->request->get('provider_size_id') . ',benf_size_id,' . $this->request->get('benf_size_id') . ',saudi_percentage_id,' . ( $this->isMethod('PATCH') ? basename($this->getUri()) : null )
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
            'provider_activity_id' => trans('saudi_percentage.attributes.provider_activity_id'),
            'benf_activity_id'     => trans('saudi_percentage.attributes.benf_activity_id'),
            'provider_size_id'     => trans('saudi_percentage.attributes.provider_size_id'),
            'benf_size_id'         => trans('saudi_percentage.attributes.benf_size_id'),
            'saudi_pct'            => trans('saudi_percentage.attributes.saudi_pct'),
        ];
    }
}
