<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestFieldValidation extends FormRequest
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
     * Set the validation rules that apply to items in the Fields table
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
                'max: 256',
            ],
        ];
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
            'description.max' => 'Maximum length for the Field description is 256 characters.',
        ];
    }
}
