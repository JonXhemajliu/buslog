<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    // List employees (Company only)
    public function index()
    {
        $this->checkCompany();
        $employees = Employee::where('company_id', Session::get('company_id'))->get();
        return view('employees.index', compact('employees'));
    }

    // Show create form
    public function create()
    {
        $this->checkCompany();
        return view('employees.create');
    }

    // Store new employee
    public function store(Request $request)
    {
        $this->checkCompany();

        $validated = $request->validate([
            'title' => 'required|string',
            'name' => 'required|string',
            'surname' => 'required|string',
            'username' => 'required|unique:employees',
            'email' => 'required|email|unique:employees',
            'password' => 'required|min:6',
        ]);

        Employee::create([
            'company_id' => Session::get('company_id'),
            'title' => $validated['title'],
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee added!');
    }

    // Edit form
    public function edit($id)
    {
        $this->checkCompany();
        $employee = Employee::findOrFail($id);
        $this->checkOwnership($employee);

        return view('employees.edit', compact('employee'));
    }

    // Update employee
    public function update(Request $request, $id)
    {
        $this->checkCompany();
        $employee = Employee::findOrFail($id);
        $this->checkOwnership($employee);

        $validated = $request->validate([
            'title' => 'required|string',
            'name' => 'required|string',
            'surname' => 'required|string',
            'username' => 'required|unique:employees,username,' . $id,
            'email' => 'required|email|unique:employees,email,' . $id,
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated!');
    }

    // Delete employee
    public function destroy($id)
    {
        $this->checkCompany();
        $employee = Employee::findOrFail($id);
        $this->checkOwnership($employee);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted!');
    }

    // Helper: Check if user is company
    private function checkCompany()
    {
        if (Session::get('user_type') !== 'company') {
            abort(403, 'Only companies can manage employees');
        }
    }

    // Helper: Check if employee belongs to this company
    private function checkOwnership($employee)
    {
        if ($employee->company_id !== Session::get('company_id')) {
            abort(403);
        }
    }
}