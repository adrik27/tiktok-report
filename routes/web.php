<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\YajraBrandController;
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

// brands
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('brands/ajax', [YajraBrandController::class, 'tampil_data'])->name('brands.ajax');
Route::post('/brands', [BrandController::class, 'create'])->name('brands.create');
Route::put('/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/{id}', [BrandController::class, 'hapus'])->name('brands.hapus');

// campaign
Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign.index');
Route::get('/campaign/create', [CampaignController::class, 'create'])->name('campaign.create');
Route::post('/campaign/create', [CampaignController::class, 'proses_create'])->name('campaign.proses_create');

// logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login.form');
})->name('logout');
