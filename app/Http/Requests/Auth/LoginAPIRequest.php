<?php

namespace App\Http\Requests\AUTH;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginAPIRequest extends FormRequest
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
     * Get the validation rules that apply to the request
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
            ],
            'password' => [
                'required',
                'min: 8',
            ]
        ];
    }

    /**
     * Create array of validation errors for a Login attempt
     *
     * @param Validator $validator
     * @return mixed
     * @throws HttpResponseException
     */
    public function failedValidation(Validator $validator): array
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'data' => $validator->errors(),
            ])
        );
    }

    /**
     * Create array of validation errors for a Login attempt
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.required' => 'An e-mail address is required',
            'email.email' => 'A valid e-mail address is required',
            'password.min' => 'The password must be at least 8 characters long'
        ];
    }
}
