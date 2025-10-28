<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// auth login manual
Route::get('/', [AuthController::class, 'tampil_login'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// auth login google
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// dashboard
Route::get('/dashboard', function () {
    return view('admin.dashboard.index', [
        'title' => 'Dashboard'
    ]);
})->name('dashboard');

// logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login.form');
})->name('logout');
