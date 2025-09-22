<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
public function showRegisterForm(){
    return view('auth.register');
}
public function register(Request $request){
    $validated=$request->validate([
        'name'=>['required','string','max:255'],
        'email'=>['required','email','string','max:255','unique:users'],
        'password'=>['required','string','min:8','confirmed'],
        'phone_number'=>['required', 'regex:/^(010|011|012|015)[0-9]{8}$/'],
        'parent_phone_number' => ['required', 'regex:/^(010|011|012|015)[0-9]{8}$/'],
    ]);
    $user=User::create([
        'name'=>$validated['name'],
        'email'=>$validated['email'],
        'password'=>Hash::make($validated['password']),
        'phone_number'=>$validated['phone_number'],
        'parent_phone_number'=>$validated['parent_phone_number'],
        'role'=>'student',
    ]);
    return redirect()->route('login')->with('success','تم التسجيل بنجاح 🎉 بالرجاء التواصل من اجل تفعيل الحساب');
}
}
