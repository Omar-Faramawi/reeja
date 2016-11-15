<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class PackageSelectRequest extends Request
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
            "requestedIshaars"=>"required|integer|min:0",
        ];
    }

    public function messages()
    {
        return [
            "requestedIshaars.required"=>trans("packagesubscribe.noRequired"),
            "requestedIshaars.*"=>trans("packagesubscribe.mustNo"),
        ];
    }
}
