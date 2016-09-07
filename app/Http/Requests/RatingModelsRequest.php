<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class RatingModelsRequest extends Request
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
        // For get the ID of editing
        $id = $this->getTargetId(3);

        $rules = [
            "name" => "required|unique:taqyeem_template,name," . $id . ',id,deleted_at,NULL'
        ];
        if (!$this->session()->has('full')) {
            $rules['question'] = "required_with:name";
            $rules['answer.*'] = "required_with:question";
        }
        
        return $rules;
    }
}
