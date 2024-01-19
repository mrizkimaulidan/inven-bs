<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return to_route('login')->withErrors([
                'email' => 'Akun tersebut tidak terdaftar di sistem!'
            ]);
        }

        $request->session()->regenerate();

        return to_route('home');
    }
}
