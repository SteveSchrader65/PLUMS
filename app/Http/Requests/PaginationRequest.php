<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PaginationRequest extends FormRequest
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
     * Set the validation rules required for pagination
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'page' => [
                'integer',
                'min: 1',
            ],
            'per_page' => [
                'integer',
                'between: 1, 9999',
            ]
        ];
    }

    /**
     * Create array of validation errors for pagination
     *
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Pagination Validation Errors:',
                'data' => $validator->errors(),
            ])
        );
    }

    /**
     * Create array of validation errors for pagination
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'page.integer' => 'Page number must be an integer numeric value.',
            'page.min' => 'Page number must be greater than or equal to 1.',
            'per_page.integer' => 'Per_page number must be an integer numeric value.',
            'per_page.between'=>"Per_page value must fall between 1 and 9999."
        ];
    }

}
