<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'first_name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|string',
            'identification_number' => 'nullable|numeric',
            'identification_type' => 'nullable|string|in:cc,ce,ti,ppn,nit',
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
