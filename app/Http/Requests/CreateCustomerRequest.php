<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'required|string|unique:customers,phone_number',
            'identification_number' => 'required|numeric|unique:customers,identification_number',
            'identification_type' => 'required|string|in:cc,ce,ti,ppn,nit',
            'gender' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'photo' => 'nullable|string',
            'source' => 'nullable|string',
            'last_name' => 'nullable|string',

            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'description' => 'nullable|string',
            'last_talked_to' => 'nullable|date',
        ];
    }
}
