<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\YajraBrandController;
use App\Http\Controllers\PerbandinganController;
use App\Http\Controllers\YajraCampaignController;
use App\Http\Controllers\YajraPerbandinganController;


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
Route::post('/campaign/ajax', [YajraCampaignController::class, 'tampil_data'])->name('campaign.ajax');
Route::get('/campaign/create', [CampaignController::class, 'create'])->name('campaign.create');
Route::post('/campaign/create', [CampaignController::class, 'proses_create'])->name('campaign.proses_create');
Route::get('/campaign/{id}/edit', [CampaignController::class, 'edit'])->name('campaign.edit');
Route::put('/campaign/{id}', [CampaignController::class, 'update'])->name('campaign.update');
Route::delete('/campaign/{id}', [CampaignController::class, 'hapus'])->name('campaign.hapus');

// perbandingan
Route::get('/perbandingan', [PerbandinganController::class, 'index'])->name('perbandingan.index');
Route::post('/perbandingan', [PerbandinganController::class, 'perbandingan'])->name('perbandingan.post');
Route::post('/perbandingan/ajax', [YajraPerbandinganController::class, 'tampil_data'])->name('perbandingan.ajax');
Route::get('/perbandingan/create', [PerbandinganController::class, 'create'])->name('perbandingan.create');
Route::post('/perbandingan/create', [PerbandinganController::class, 'proses_create'])->name('perbandingan.proses_create');
Route::get('/perbandingan/{id}/edit', [PerbandinganController::class, 'edit'])->name('perbandingan.edit');
Route::put('/perbandingan/{id}', [PerbandinganController::class, 'update'])->name('perbandingan.update');
Route::delete('/perbandingan/{id}', [PerbandinganController::class, 'hapus'])->name('perbandingan.hapus');


// logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login.form');
})->name('logout');
