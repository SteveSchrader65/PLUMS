<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class APIAnswerValidation extends FormRequest
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
     * Set the validation rules that apply to attributes of the Answers table
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'answer_text' => [
                'required',
                'min: 5',
                'max: 256',
            ],
            'is_correct' => [
                'required',
                'boolean',
            ],
        ];
    }

    /**
     * Create array of validation errors for Answers in the database
     *
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Answer Validation Errors:',
            'data' => $validator->errors()
        ]));
    }

    /**
     * Validation error messages for creating/updating an Answer record
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'answer_text.required' => 'A text-string for the Answer is required.',
            'answer_text.min' => 'Minimum length of a quiz Answer is 5 characters.',
            'answer_text.max' => 'Maximum length of a quiz Answer is 256 characters.',
            'is_correct.required' => 'Indicate if this Answer is correct',
            'is_correct.boolean' => 'Please indicate if this answer is correct.',
        ];
    }
}
