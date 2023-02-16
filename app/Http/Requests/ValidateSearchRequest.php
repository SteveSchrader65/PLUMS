<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidateSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Set the validation rules that apply to a field search
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'search' => [
                'required',
                'max: 64',
                'string',
            ],
        ];
    }

    /**
     * Create array of validation errors for a Search query
     *
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Search Validation Errors:',
            'data' => $validator->errors()
        ]));
    }

    /**
     * Create array of validation errors for a Search query
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'search.required' => ' A search term is required.',
            'search.max' => 'Search term can be up to 64 characters in length.',
            'search.string' => 'Search term must contain alpha-numeric characters.',
        ];
    }}
