<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestUserValidation extends FormRequest
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
     * Set the validation rules that apply to items in the Users table
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
                'size: 3',
            ],
            'email' => [
                'required',
                'email',
            ],
            'user_id' => [
                'required',
                'integer',
            ]
        ];
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
            'country.required' => 'Country name is required.',
            'country.size' => 'Country code must be 3 characters in length.',
            'email.required' => 'An e-mail address is required.',
            'email.email' => 'A valid e-mail address is required.',
            'user_id.required' => 'A \'user_id\' is required to match profile.',
            'user_id.integer' => 'An integer value is required for \'user_id\'.',
        ];
    }
}
