<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class UpdateEstResponsiblesRequest extends Request
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
        $rules = [];
        foreach ($this->get('resp_data') as $key => $data) {
            $rules['resp_data.' . $key . '.id_number'] = 'required|integer|min:0|max:9999999999999';
            $rules['resp_data.' . $key . '.responsible_name'] = 'required|min:3|max:255';
            $rules['resp_data.' . $key . '.job_name'] = 'required|min:3|max:255';
            $rules['resp_data.' . $key . '.responsible_phone'] = 'required|phone_number|min:0|max:9999999999999';
            $rules['resp_data.' . $key . '.responsible_email'] = 'required|email';
            $rules['resp_data.' . $key . '.id'] = 'exists:est_responsibles,id';
        }
        $rules['est_type'] = 'sometimes|required';

        return $rules;
    }

    public function attributes()
    {
        $trans_attributes = trans('est_profile.responsibles_attributes');

        $attributes = [];

        foreach ($this->get('resp_data') as $key => $data) {
            foreach ($data as $k => $v) {
                $attributes['resp_data.' . ($key) . '.' . $k] = $trans_attributes[$k] . ' (' . strval($key + 1).') ';
            }
        }

        $attributes['est_type'] = trans('est_profile.est_type');

        return $attributes;

    }

    public function messages()
    {
        $messages['est_type'] = trans('est_profile.est_type_error_message');
        foreach ($this->get('resp_data') as $key => $data) {
            $messages['resp_data.' . $key . '.id_number.max'] = trans('est_profile.responsibles_attributes.id_number').' '.trans('labels.number').' ('.strval($key+1).') '.trans('est_profile.invalid');
            $messages['resp_data.' . $key . '.responsible_phone.phone_number'] = trans('est_profile.responsibles_attributes.responsible_phone').' '.trans('labels.number').' ('.strval($key+1).') '.trans('est_profile.invalid');
        }
        return $messages;
    }
}
