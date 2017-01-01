<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class SearchEstablishmentsRequest extends Request
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
            "labour_office_no" => "required|exists:establishments,labour_office_no,id,!" . session()->get('selected_establishment.id'),
            "sequence_no"      => "required|exists:establishments,sequence_no,id,!" . session()->get('selected_establishment.id'),
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
            'labour_office_no' => trans('establishments_registration.attributes.labour_office_no'),
            'sequence_no'      => trans('establishments_registration.attributes.sequence_no'),
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'labour_office_no.exists' => trans('taqawoul.establishment_not_found'),
            'sequence_no.exists' => trans('taqawoul.establishment_not_found'),
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return array_unique($validator->errors()->all());
    }
}
