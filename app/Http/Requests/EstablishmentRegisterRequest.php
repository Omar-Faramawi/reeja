<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class EstablishmentRegisterRequest extends Request
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
        if (Request::input('est_id')) {
            return [
                'branch_no'         => 'integer|min:0'
            ];
        } else {
            return [
                'labour_office_no'  => 'required|integer',
                'sequence_no'       => 'required|integer',
                'id_number'         => 'required|integer',
                'est_activity'      => 'required',
                'est_size'          => 'required',
                'est_nitaq'         => 'required',
                'district'          => 'required',
                'city'              => 'required',
                'region'            => 'required',
                'wasel_address'     => 'required',
                'local_liecense_no' => 'required|integer',
                'phone'             => 'required',
                'branch_no'         => 'integer|min:0',
                'name'              => 'required|unique:establishments,name,'.Request::input('est_id').',id,deleted_at,NULL',
                'email'             => 'required|email|unique:users,email,'.Request::input('users_id').',id,deleted_at,NULL',
            ];
        }
    }

    public function attributes()
    {
        return [
            'labour_office_no'  => trans('establishments_registration.attributes.labour_office_no'),
            'sequence_no'       => trans('establishments_registration.attributes.sequence_no'),
            'id_number'         => trans('establishments_registration.attributes.id_number'),
            'est_activity'      => trans('establishments_registration.attributes.est_activity'),
            'est_size'          => trans('establishments_registration.attributes.est_size'),
            'est_nitaq'         => trans('establishments_registration.attributes.est_nitaq'),
            'district'          => trans('establishments_registration.attributes.district'),
            'city'              => trans('establishments_registration.attributes.city'),
            'region'            => trans('establishments_registration.attributes.region'),
            'wasel_address'     => trans('establishments_registration.attributes.wasel_address'),
            'local_liecense_no' => trans('establishments_registration.attributes.local_liecense_no'),
            'phone'             => trans('establishments_registration.attributes.phone'),
            'branch_no'         => trans('establishments_registration.attributes.branch_no'),
            'name'              => trans('establishments_registration.attributes.name'),
            'email'             => trans('establishments_registration.attributes.email'),
        ];
    }
}
