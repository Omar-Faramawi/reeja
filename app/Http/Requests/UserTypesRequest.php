<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;
use Hashids;

class UserTypesRequest extends Request
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
        // For get the target ID of editing
        $id = $this->getTargetId(4);
        
        return [
            'name' => 'required|min:3|max:255|unique:user_types,name,' . $id . ',id,deleted_at,NULL',
        ];
    }
}
