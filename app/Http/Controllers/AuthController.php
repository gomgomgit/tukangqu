<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function loginProcess(Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('name', 'password');

        $isSuccess = Auth::attempt($credentials, $request->remember);

        if ($isSuccess) {
            return redirect()->intended('/admin/dashboard');
        } else {
            return redirect()->back()->with(['error' => 'Your data false or have not registered']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
