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
    $request->validate([
        'login' => 'required|string',
        'password' => 'required|string',
    ], [
        'login.required' => 'Email-i ose username është i detyrueshëm.',
        'password.required' => 'Fjalëkalimi është i detyrueshëm.',
    ]);

    $login = trim($request->login);
    $password = $request->password;

    // Kompania hyn me email
    if (Auth::guard('company')->attempt(['email' => $login, 'password' => $password])) {
        $request->session()->regenerate();
        return redirect()->route('company.dashboard');
    }

    // Punonjësi hyn me email ose username
    $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    if (Auth::guard('employee')->attempt([$field => $login, 'password' => $password])) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    return back()
        ->withErrors(['login' => 'Email/username ose fjalëkalim i gabuar.'])
        ->withInput($request->only('login'));
}

  public function logout(Request $request)
{
    Auth::guard('company')->logout();
    Auth::guard('employee')->logout(); 

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home');
}}