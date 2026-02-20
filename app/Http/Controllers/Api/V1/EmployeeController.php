<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\EmployeeRepositoryInterface;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    private $employeeRepo;

    public function __construct(EmployeeRepositoryInterface $employeeRepo)
    {
        $this->middleware('auth:api');  // OAuth2 protection
        $this->employeeRepo = $employeeRepo;
    }

    // List employees with filters and pagination
    public function index(Request $request)
    {
        return response()->json($this->employeeRepo->getAll($request->all()), 200);
    }

    // Create new employee
    public function store(StoreEmployeeRequest $request)
    {
        $employee = $this->employeeRepo->create($request->validated());
        return response()->json($employee, 201);
    }

    // Show single employee
    public function show($id)
    {
        return response()->json($this->employeeRepo->find($id), 200);
    }

    // Update employee
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = $this->employeeRepo->update($id, $request->validated());
        return response()->json($employee, 200);
    }

    // Delete employee
    public function destroy($id)
    {
        $this->employeeRepo->delete($id);
        return response()->json(['message' => 'Deleted'], 204);
        // return response()->noContent();
    }
}
