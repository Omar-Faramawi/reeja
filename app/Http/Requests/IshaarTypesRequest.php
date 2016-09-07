<?php

namespace Tamkeen\Ajeer\Http\Requests;

class IshaarTypesRequest extends Request
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
        $id = $this->getTargetId();

        return [
            'name' => 'required|min:3|max:255|unique:ishaar_types,name,' . $id . ',id,deleted_at,NULL',
        ];
    }
}
