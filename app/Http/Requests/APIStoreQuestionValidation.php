<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class APIStoreQuestionValidation extends FormRequest
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
     * Set the validation rules that apply to attributes of the Questions table
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

                // THIS MAY BE MEASURING LENGTH OF THE STRING ???
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
        ];
    }

    /**
     * Create array of validation errors for Questions in the database
     *
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Question Validation Errors:',
            'data' => $validator->errors()
        ]));
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
            'answer_set.required' => 'Please enter an array of AnswerIDs enclosed in [] brackets.',
            'answer_set.min' => 'An answer-set for a Question requires at least 2 Answers.',
            'points_value.required' => 'A Point value for the question is required.',
            'points_value.min' => 'Minimum Point value for a question is 0.25.',
            'is_available.required' => 'Indicate if Question is available for usage.',
            'is_available.boolean' => 'Please indicate if Question is available.',
        ];
    }
}
