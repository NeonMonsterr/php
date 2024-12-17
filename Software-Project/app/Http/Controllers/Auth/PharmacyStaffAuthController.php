<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PharmacyStaff;
use Illuminate\Support\Facades\Hash;

class PharmacyStaffAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.staff.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            
        ]);

        if (Auth::guard('staff')->attempt($request->only('email', 'password'))) {
            return redirect()->intended('/staff/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function showRegisterForm()
    {
        return view('auth.staff.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pharmacy_staff,email',
            'password' => 'required|min:6|confirmed',
        ]);

        PharmacyStaff::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('staff.login')->with('success', 'Account created successfully.');
    }

    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        return redirect()->route('staff.login');
    }
}
