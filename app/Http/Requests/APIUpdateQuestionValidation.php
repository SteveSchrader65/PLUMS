<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class APIUpdateQuestionValidation extends FormRequest
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
            'written_by' => [
                'required',
                'integer',
            ],
            'times_used' => [
                'required',
                'integer',
            ],
            'times_answered_correctly' => [
                'required',
                'integer',
            ],
            'times_answered_incorrectly' => [
                'required',
                'integer',
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
            'written_by.required' => 'An AuthorID of the question-creator is required.',
            'written_by.integer' => 'The \'written-by\' value must be an integer.',
            'times_used.required' => 'A value to indicate the number of times this question has been used is required.',
            'times_used.integer' => 'The \'times_used\' value must be an integer.',
            'times_answered_correctly.required' => 'A value to indicate the number of times this question has been answered correctly is required.',
            'times_answered_correctly.integer' => 'The \'times_answered_correctly\' value must be an integer.',
            'times_answered_incorrectly.required' => 'A value to indicate the number of times this question has been answered incorrectly is required.',
            'times_answered_incorrectly.integer' => 'The \'times_answered_incorrectly\' value must be an integer.',
        ];
    }
}
