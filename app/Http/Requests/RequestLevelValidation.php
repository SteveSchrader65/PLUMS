<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestLevelValidation extends FormRequest
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
     * Set the validation rules that apply to items in the AQF Levels table
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'AQF_level' => [
                'required',
                'min: 1',
                'max: 10',
            ],
            'title' => [
                'required',
                'min: 3',
                'max: 32',
            ],
            'description' => [
                'required',
                'min: 10',
                'max: 256',
            ]
        ];
    }

    /**
     * Validation error messages for creating/updating an AQF Level record
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'AQF_level.required' => 'An AQF Level is required.',
            'AQF_level.min' => 'The minimum AQF Level is 1.',
            'AQF_level.max' => 'The maximum AQF Level is 10.',
            'title.required' => 'A Level title is required.',
            'title.min' => 'Minimum length for the Level title is 3 characters.',
            'title.max' => 'Maximum length for the Level title is 32 characters.',
            'description.required' => 'A Level description is required.',
            'description.min' => 'Minimum length for the Level description is 10 characters.',
            'description.max' => 'Maximum length for the Level title is 256 characters.',
        ];
    }
}
