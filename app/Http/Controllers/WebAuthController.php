<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebAuthController extends Controller
{
    /**
     * Tampilkan halaman formulir login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Tampilkan halaman formulir registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }
}
