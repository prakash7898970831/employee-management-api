<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
        $employeeId = $this->route('id');

        return [
            'department_id' => 'sometimes|required|exists:departments,id',
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'email' => 'sometimes|required|email|unique:employees,email,' . $employeeId,

            'contact_numbers' => 'sometimes|required|array|min:1',
            'contact_numbers.*.contact_number' => 'required|string|max:20',
            'contact_numbers.*.type' => 'nullable|string|max:12',

            'addresses' => 'sometimes|required|array|min:1',
            'addresses.*.address_line1' => 'required|string|max:255',
            'addresses.*.address_line2' => 'nullable|string|max:255',
            'addresses.*.city' => 'required|string|max:255',
            'addresses.*.state' => 'required|string|max:255',
            'addresses.*.country' => 'required|string|max:255',
            'addresses.*.pincode' => 'required|string|max:10',
        ];
    }
}
