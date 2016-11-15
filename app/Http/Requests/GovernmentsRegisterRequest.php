<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class GovernmentsRegisterRequest extends Request
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
        $id = $this->getTargetId(4);

        return [
            'name'  => 'required|min:3|max:255|unique:governments,name,' . $id . ',id,deleted_at,NULL',
            'email' => 'required|sometimes|email|unique:users,email,'.Request::input('user_id').',id,deleted_at,NULL',
            'hajj'  => 'integer:0,1',
        ];
    }
    
    
}
