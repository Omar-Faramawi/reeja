<?php

namespace Tamkeen\Ajeer\Http\Requests;

use Tamkeen\Ajeer\Http\Requests\Request;

class QuestionAndAnswerRequest extends Request
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
        $rules = [
            "question"  => "required",
            "answers.*" => "required"
        ];


        return $rules;
    }


    /**
     * @return array
     */
    public function messages()
    {
        return [
            'question.required'  => trans('ratingmodels.messages.questionRequired'),
            "answers.*.required" => trans("ratingmodels.messages.answersRequired")
        ];
    }
}
