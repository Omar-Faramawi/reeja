<?php

namespace Tamkeen\Ajeer\Http\Requests;

class OccupationSearchRequest extends Request
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
            'q' => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'q.required' => trans('occupation_managment.search.required'),
            'q.min'      => trans('occupation_managment.search.atleast3chars')
        ];
    }
}
