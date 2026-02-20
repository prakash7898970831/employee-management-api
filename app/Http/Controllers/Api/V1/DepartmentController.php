<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    // Display a listing of departments
    public function index(Request $request)
    {
        $query = Department::query();
        // Optional search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $departments = $query->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Departments retrieved successfully.',
            'data' => $departments
        ], 200);
    }

    //Store created department
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $department = Department::create($validated);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Department created successfully.',
                'data' => $department
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Department creation failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Display the specific department
    public function show($id)
    {
        $department = Department::with('employees')->find($id);

        if (!$department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Department retrieved successfully.',
            'data' => $department
        ], 200);
    }

    //Update the specified department
    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found.'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $department->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully.',
            'data' => $department
        ], 200);
    }

    //Remove the specified department
    public function destroy($id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found.'
            ], 404);
        }

        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully.'
        ], 200);
    }
}