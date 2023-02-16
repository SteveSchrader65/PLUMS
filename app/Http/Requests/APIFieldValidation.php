<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class APIFieldValidation extends FormRequest
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
     * Set the validation rules that apply to attributes of the Fields table
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min: 3'.
                'max: 32',
            ],
            'description' => [
                'required',
                'min: 10',
                'max: 512',
            ],
        ];
    }

    /**
     * Create array of validation errors for the Study-Fields in the database
     *
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Study-Field Validation Errors:',
            'data' => $validator->errors()
        ]));
    }

    /**
     * Validation error messages for creating/updating a Study-field record
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'A Field name is required.',
            'name.min' => 'Minimum length for the Field name is 3 characters.',
            'name.max' => 'Maximum length for the Field name is 32 characters.',
            'description.required' => 'A Level description is required.',
            'description.min' => 'Minimum length for the Field description is 10 characters.',
            'description.max' => 'Maximum length for the Field description is 512 characters.',
        ];
    }
}
