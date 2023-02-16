<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class APISkillValidation extends FormRequest
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
     * Set the validation rules that apply to attributes of the Skills table
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min: 3',
                'max: 64',
            ],
            'description' => [
                'required',
                'min: 10',
                'max: 512',
            ],
            'field_id' => [
                'required',
                'integer',
                'exists:fields,id',
            ],
        ];
    }

    /**
     * Create array of validation errors for Skills in the database
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
     * Validation error messages for creating/updating a Skill record
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'A Skill name is required.',
            'name.min' => 'Minimum length of Skill name is 3 characters.',
            'name.max' => 'Maximum length of Skill name is 64 characters.',
            'description.required' => 'A Skill description is required.',
            'description.min' => 'Minimum length of Skill description is 10 characters.',
            'description.max' => 'Maximum length of Skill description is 512 characters',
            'field_id.required' => 'A value to indicate which Field this Skill belongs to is required.',
            'field_id.integer' => 'The \'field_id\' value must be an integer.',
            'field_id.exists' => 'The FieldID does not exist.'
        ];
    }
}
