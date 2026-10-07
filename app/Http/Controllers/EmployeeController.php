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
        $employees = Employee::where('company_id', auth('company')->id())->get();
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
            'company_id' => auth('company')->id(),
            'title' => $validated['title'],
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
return redirect()->route('company.dashboard')
    ->with('tab', 'employees')
    ->with('success', 'Punonjësi u shtua me sukses!');
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

return redirect()->route('company.dashboard')
    ->with('tab', 'employees')
    ->with('success', 'Punonjësi u përditësua me sukses!');    }

    // Delete employee
    public function destroy($id)
    {
        $this->checkCompany();
        $employee = Employee::findOrFail($id);
        $this->checkOwnership($employee);
        $employee->delete();

        return redirect()->route('company.dashboard')
    ->with('tab', 'employees')
    ->with('success', 'Punonjësi u fshi me sukses!');
    }

private function checkCompany()
{
    if (!auth('company')->check()) {
        abort(403, 'Only companies can manage employees');
    }
}

    // Helper: Check if employee belongs to this company
    private function checkOwnership($employee)
    {
        if ($employee->company_id !== auth('company')->id()) {
            abort(403);
        }
    }
}