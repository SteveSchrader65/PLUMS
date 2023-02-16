<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestQuestionValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Set the validation rules that apply to items in the Questions table
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'question_text' => [
                'required',
                'min: 5',
                'max: 512',
            ],
            'answer_set' => [
                'required',
                'min: 2',
            ],
            'points_value' => [
                'required',
                'min: 0.25',
            ],
            'is_available' => [
                'required',
                'boolean',
            ],


//            'times_used' => [
//                'integer'
//            ]
        ];
    }

    /**
     * Validation error messages for creating/updating a Question record
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'question_text.required' => 'A text-string for the Question is required.',
            'question_text.min' => 'Question text must be a minimum of 5 characters.',
            'question_text.max' => 'Question text must be a maximum of 512 characters.',
            'answer_set.required' => 'A question needs at least two potential answers.',
            'answer_set.min' => 'A question needs at least two potential answers.',
            'points_value.required' => 'A Point value for the question is required.',
            'points_value.min' => 'Minimum Point value for a question is 0.25.',
            'is_available.required' => 'Indicate if Question is available for usage.',
            'is_available.boolean' => 'Please indicate if Question is available.',

//            'times_used.integer' => 'This value must be an integer.',
        ];
    }
}
