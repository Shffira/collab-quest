<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WebAuthController;
use Illuminate\Support\Facades\Route;

// Halaman Utama & Dashboard Tugas
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

// Halaman Autentikasi
Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
