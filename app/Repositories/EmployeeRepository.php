<?php

namespace App\Repositories;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getAll($filters)
    {
        $query = Employee::with(['department', 'contacts', 'addresses']);

        if (isset($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (isset($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('first_name', 'like', "%{$filters['search']}%")
                  ->orWhere('last_name', 'like', "%{$filters['search']}%");
            });
        }

        return $query->paginate(10);
    }

    public function find($id)
    {
        return Employee::with(['department','contacts','addresses'])->findOrFail($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $employeeData = $data;
            unset($employeeData['contact_numbers'], $employeeData['addresses']);

            $employee = Employee::create($employeeData);
            // Contacts
            if (!empty($data['contact_numbers'])) {
                foreach ($data['contact_numbers'] as $contact) {
                    $employee->contacts()->create([
                        'contact_number' => $contact['contact_number'],
                        'type' => $contact['type'], 
                    ]);
                }
            }

            // Addresses
            if (!empty($data['addresses'])) {
                foreach ($data['addresses'] as $address) {
                    $employee->addresses()->create([
                        'address_line1' => $address['address_line1'],
                        'address_line2' => $address['address_line2'] ?? null,
                        'city' => $address['city'],
                        'state' => $address['state'],
                        'country' => $address['country'],
                        'pincode' => $address['pincode'],
                    ]);
                }
            }

            DB::commit();
            return $employee->load(['department', 'contacts', 'addresses']);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::findOrFail($id);
            $employeeData = $data;
            unset($employeeData['contact_numbers'], $employeeData['addresses']);

            $employee->update($employeeData);

            // Update contacts
            if (isset($data['contact_numbers'])) {
                $employee->contacts()->delete();
                foreach ($data['contact_numbers'] as $contact) {
                    $employee->contacts()->create([
                        'contact_number' => $contact['contact_number'],
                        'type' => $contact['type'], 
                    ]);
                }
            }

            // Update addresses
            if (isset($data['addresses'])) {
                $employee->addresses()->delete();
                foreach ($data['addresses'] as $address) {
                    $employee->addresses()->create([
                        'address_line1' => $address['address_line1'],
                        'address_line2' => $address['address_line2'] ?? null,
                        'city' => $address['city'],
                        'state' => $address['state'],
                        'country' => $address['country'],
                        'pincode' => $address['pincode'],
                    ]);
                }
            }

            DB::commit();
            return $employee->load(['department', 'contacts', 'addresses']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->contacts()->delete();
        $employee->addresses()->delete();
        return $employee->delete();
    }
}