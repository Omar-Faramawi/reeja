<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Hashids;

class PublishLaborerRequest extends Request
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

            'startdate'    => 'date|required_with:enddate',
            'enddate'      => 'date|required_with:startdate',
            'id'           => 'required'
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
            'startdate'    => trans('add_laborer.work_start_date'),
            'enddate'      => trans('add_laborer.work_end_date'),
            'id'           => trans('add_laborer.id')
		];
	}
}
