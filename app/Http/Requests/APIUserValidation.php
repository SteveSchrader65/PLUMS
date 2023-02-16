<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class APIUserValidation extends FormRequest
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
     * Set the validation rules that apply to attributes of the Users table
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'given_name' => [
                'required',
                'min: 2',
                'max: 32',
            ],
            'family_name' => [
                'required',
                'min: 2',
                'max: 64',
            ],
            'city' => [
                'required',
                'min: 3',
                'max: 32',
            ],
            'country' => [
                'required',
                // NOTE: MODIFY VALIDATION TO EXCLUDE CURRENT COUNTRY
                'exists:countries,code_3',
            ],
            'email' => [
                'required',
                'email: rfc, dns',
                // NOTE: MODIFY VALIDATION TO EXCLUDE CURRENT EMAIL ADDRESS
                'unique:users'
            ],
            'password' => [
                'required',
                'min: 8',
            ],
        ];
    }

    /**
     * Create array of validation errors for Users in the database
     *
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'User Validation Errors:',
            'data' => $validator->errors()
        ]));
    }

    /**
     * Validation error messages for creating/updating a User record
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'given_name.required' => 'The given name is required.',
            'given_name.min' => 'User given name must be a minimum of 2 characters.',
            'given_name.max' => 'User given name must be a maximum 32 characters.',
            'family_name.required' => 'The family name is required.',
            'family_name.min' => 'User family name must be a minimum of 2 characters.',
            'family_name.max' => 'User family name must be a maximum of 64 characters.',
            'city.required' => 'City name is required.',
            'city.min' => 'City name must be a minimum of 3 characters.',
            'city.max' => 'City name must be a maximum of 32 characters.',
            'country.required' => 'Country code is required.',
            'country.exists' => 'The Country cannot be found.',
            'level_id.exists' => 'The LevelID does not exist.',
            'email.required' => 'An e-mail address is required.',
            'email.email' => 'A valid e-mail address is required.',
            'email.unique' => 'A unique e-mail address is required.',
            'password.required' => 'A password is required.',
            'password.min' => 'Password must be at least 8 characters in length.',
        ];
    }
}
