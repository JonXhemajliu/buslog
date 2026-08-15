<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EmployeeProfileController extends Controller
{
    // Edit own profile
    public function edit()
    {
        $employee = Employee::findOrFail(Session::get('employee_id'));
        return view('profile.edit', compact('employee'));
    }

    // Update email & password
    public function update(Request $request)
    {
        $employee = Employee::findOrFail(Session::get('employee_id'));

        $validated = $request->validate([
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'password' => 'nullable|min:6',
        ]);

        $employee->email = $validated['email'];
        if ($validated['password']) {
            $employee->password = Hash::make($validated['password']);
        }
        $employee->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated!');
    }
}