<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestQuizValidation extends FormRequest
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
     * Set the validation rules that apply to items in the Quizzes table
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'min: 5',
                'max: 32',
            ],
            'description' => [
                'required',
                'min: 10',
                'max: 128',
            ],
            'question_set' => [
                'required',
                'min: 3',
            ],
            'level_id' => [
                'required',
                'min: 1',
                'lte: level_id.max()',
            ],
            'field_id' => [
                'required',
                'min: 1',
                'lte: field_id.max()',
            ],
            'skill_id' => [
                'required',
                'min: 1',
                'lte: skill_id.max()',
            ],
            'is_available' => [
                'required',
                'boolean',
            ],
        ];
    }

    /**
     * Validation error messages for creating/updating a Quiz record
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A Quiz title is required.',
            'title.min' => 'Minimum length of Quiz title is 5 characters.',
            'title.max' => 'Maximum length of Quiz title is 32 characters.',
            'description.required' => 'A description of thw Quiz is required.',
            'description.min' => 'Minimum length of Quiz description is 10 characters.',
            'description.max' => 'Maximum length of Quiz description is 128 characters.',
            'level_id.required' => 'An AQF level is required for the Quiz.',
            'level_id.min' => 'The Quiz must have a minimum AQF level of 1.',
            'level_id.lte' => 'AQF level cannot exceed available maximum.',
            'field_id.required' => 'A Field ID is required for the Quiz.',
            'field_id.min' => 'The Quiz must have a minimum Field ID of 1.',
            'field_id.lte' => 'The Field ID cannot exceed available maximum.',
            'skill_id.required' => 'A Skill level is required to the Quiz.',
            'skill_id.min' => 'The Quiz must have a minimum Skill level of 1.',
            'skill_id.lte' => 'Skill level cannot exceed available maximum.',
            'is_available.required' => 'Indicate if Quiz is available for publication.',
            'is_available.boolean' => 'Please indicate if Question is available.',
        ];
    }
}
