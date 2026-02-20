<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'department_id' => 'required|exists:departments,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'designation' => 'nullable|string|max:255',
            'email' => 'required|email|unique:employees,email',

            'contact_numbers' => 'required|array|min:1',
            'contact_numbers.*.contact_number' => 'required|string|max:20',
            'contact_numbers.*.type' => 'nullable|string|max:12',
            
            'addresses' => 'required|array|min:1',
            'addresses.*.address_line1' => 'required|string|max:255',
            'addresses.*.address_line2' => 'nullable|string|max:255',
            'addresses.*.city' => 'required|string|max:255',
            'addresses.*.state' => 'required|string|max:255',
            'addresses.*.country' => 'required|string|max:255',
            'addresses.*.pincode' => 'required|string|max:10',
        ];
    }
}
