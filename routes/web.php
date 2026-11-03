<?php

use Illuminate\Support\Facades\Route;

// Halaman Utama & Dashboard
Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Halaman Autentikasi
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});
