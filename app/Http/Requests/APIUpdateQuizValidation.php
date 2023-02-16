<?php

namespace App\Http\Requests;

use App\Models\Field;
use App\Models\Level;
use App\Models\Skill;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class APIUpdateQuizValidation extends FormRequest
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
     * Set the validation rules that apply to attributes of the Quizzes table
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                // NOTE: MODIFY VALIDATION TO EXCLUDE CURRENT TITLE
                'unique:quizzes,title',
                'min: 5',
                'max: 128',
            ],
            'description' => [
                'required',
                'min: 10',
                'max: 512',
            ],
            'question_set' => [
                'required',
                'min: 4',
            ],
            'level_id' => [
                'exists:levels,id',
            ],
            'field_id' => [
                'exists:fields,id',
            ],
            'skill_id' => [
                'exists:skills,id',
            ],
            'is_available' => [
                'required',
                'boolean',
            ],
            'prepared_by' => [
                'required',
                'integer',
            ],
            'times_attempted' => [
                'required',
                'integer',
            ],
            'fastest_time' => [
                'required',
                'string',
            ],
            'average_time' => [
                'required',
                'string',
            ],
        ];
    }

    /**
     * Create array of validation errors for Quizzes in the database
     *
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Quiz Validation Errors:',
            'data' => $validator->errors()
        ]));
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
            'title.unique' => 'A unique Quiz title is required',
            'title.min' => 'Minimum length of Quiz title is 5 characters.',
            'title.max' => 'Maximum length of Quiz title is 128 characters.',
            'description.required' => 'A description of thw Quiz is required.',
            'description.min' => 'Minimum length of Quiz description is 10 characters.',
            'description.max' => 'Maximum length of Quiz description is 512 characters.',
            'question_set.required' => 'Please enter an array of QuestionIDs enclosed in [] brackets.',
            'question_set.min' => 'A question-set for a Quiz requires at least 4 Questions.',
            'level_id.exists' => 'The LevelID does not exist.',
            'field_id.exists' => 'The FieldID does not exist.',
            'skill_id.exists' => 'The SkillID does not exist.',
            'is_available.required' => 'Indicate if this Quiz is available for publication.',
            'is_available.boolean' => 'Please indicate if this Quiz is available.',
            'prepared_by.required' => 'A User ID# is required to indicate who prepared the Quiz',
            'prepared_by.integer' => 'The value for \'prepared_by\' must be an integer.',
            'times_attempted.required' => 'A value is required to indicate the number of times this Quiz has been attempted.',
            'times_attempted.integer' => 'The value for \'times_attempted\' must be an integer.',
            'fastest_time.required' => 'A time-value is required to indicate the fastest time this Quiz has been completed.',
            'fastest_time.string' => 'The value for \'fastest_time\' must be a time-value.',
            'average_time.required' => 'A time-value is required to indicate the average time this Quiz is completed.',
            'average_time.string' => 'The value for \'average_time\' must be a time-value.',
        ];
    }
}
