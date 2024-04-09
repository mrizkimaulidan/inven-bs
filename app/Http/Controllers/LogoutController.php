<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        auth()->logout();

        return to_route('login')->with('success', 'Berhasil keluar dari aplikasi!');
    }
}
