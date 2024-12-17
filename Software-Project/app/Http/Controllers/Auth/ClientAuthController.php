<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.client.login');
    }

    public function login(Request $request)
    {
        $validData= $request->validate([
            'password' => 'required|min:6',
            'email' => 'required|email|exists:client,email',
        ]);
        $attempt = Auth::guard('client')->attempt([
            'email' => $validData['email'],
            'password' => $validData['password'],
        ]);

        if ($attempt) {
            $request->session()->regenerate();
                        return redirect()->route('home');
        }else {
            return back()->withErrors(['error' => 'Invalid credentials.']);
        }
    }

    public function showRegisterForm()
    {
        return view('auth.client.register');
    }

    public function register(Request $request)
    {
    $validate = $request->validate([
        'Fname' => 'required|string|max:255',
        'Lname' => 'required|string|max:255',
        'email' => 'required|email|unique:client,email',
        'password' => 'required|min:6|confirmed',
    ]);
    $validate['password'] = Hash::make($request->password);
    Client::create($validate);
    return redirect()->route('login')->with('success', 'Account created successfully.');
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        return redirect()->route('client.login');
    }
}
