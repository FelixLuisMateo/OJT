<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:6',
            'role'=>'required|in:student,coordinator,supervisor,admin',
            'course_id'=>'nullable|exists:courses,id',
        ]);

        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'role'=>$data['role'],
            'course_id'=>$data['course_id'] ?? null,
        ]);

        auth()->login($user);

        return redirect('/dashboard');
    }
}