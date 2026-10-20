<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeProfileController extends Controller
{
    public function update(Request $request)
    {
        $employee = auth('employee')->user();

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'surname'  => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:employees,username,' . $employee->id,
            'email'    => 'required|email|unique:employees,email,' . $employee->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $employee->update($data);

        return redirect()->route('dashboard')->with('success', 'Profili u përditësua!');
    }
}