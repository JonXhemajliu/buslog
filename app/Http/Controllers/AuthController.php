<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Company Registration
    public function registerCompany(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies',
            'password' => 'required|min:6|confirmed',
        ]);

        $company = Company::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // ✅ Auto-login me Laravel Auth
        Auth::guard('company')->login($company);

        return redirect()->route('company.dashboard')->with('success', 'Company registered!');
    }

    // Login (Company & Employee)
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Try Employee Login
        $employee = Employee::where('username', $validated['username'])->first();
        if ($employee && Hash::check($validated['password'], $employee->password)) {
            Auth::guard('employee')->login($employee);
            return redirect()->route('track-buses');
        }

        // Try Company Login
        $company = Company::where('email', $validated['username'])->first();
        if ($company && Hash::check($validated['password'], $company->password)) {
            Auth::guard('company')->login($company);
            return redirect()->route('company.dashboard');
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}