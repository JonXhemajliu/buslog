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
    $credentials = $request->only('email', 'password');

    if (Auth::guard('company')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('company.dashboard');
    }

    if (Auth::guard('employee')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    return back()->withErrors(['email' => 'Email ose fjalëkalim i gabuar.'])->withInput();
}

  public function logout(Request $request)
{
    Auth::guard('company')->logout();
    Auth::guard('employee')->logout(); 

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
}}