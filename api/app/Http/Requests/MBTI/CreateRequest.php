<?php

namespace App\Http\Requests\MBTI;

use App\Models\Question;
use App\Http\Requests\ApiRequest;

class CreateRequest extends ApiRequest
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
            'email' => 'required|email',
            'responses' => 'required|min:' . Question::count() . '|max:' . Question::count(),
            'responses.*.question_id' => 'required|exists:questions,id',
            'responses.*.choice' => 'required|numeric|min:1|max:7',
            'responses.*.dimension' => 'required|in:EI,SN,TF,JP',
            'responses.*.direction' => 'required|in:1,-1'
        ];
    }

    public function messages()
    {
        return [
            'responses.min' => 'Responses must be provided for each question',
            'responses.max' => 'Responses must be provided for each question'
        ];
    }
}
