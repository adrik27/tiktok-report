<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DashboardController;
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
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('admin');

// brands
Route::get('/brands', [BrandController::class, 'index'])->name('brands.index')->middleware('admin');
Route::get('brands/ajax', [YajraBrandController::class, 'tampil_data'])->name('brands.ajax');
Route::post('/brands', [BrandController::class, 'create'])->name('brands.create');
Route::put('/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/{id}', [BrandController::class, 'hapus'])->name('brands.hapus');

// campaign
Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign.index')->middleware('admin');
Route::post('/campaign/ajax', [YajraCampaignController::class, 'tampil_data'])->name('campaign.ajax');
Route::get('/campaign/create', [CampaignController::class, 'create'])->name('campaign.create')->middleware('admin');
Route::post('/campaign/create', [CampaignController::class, 'proses_create'])->name('campaign.proses_create');
Route::get('/campaign/{id}/edit', [CampaignController::class, 'edit'])->name('campaign.edit')->middleware('admin');
Route::put('/campaign/{id}', [CampaignController::class, 'update'])->name('campaign.update');
Route::delete('/campaign/{id}', [CampaignController::class, 'hapus'])->name('campaign.hapus');

// perbandingan
Route::get('/perbandingan', [PerbandinganController::class, 'index'])->name('perbandingan.index')->middleware('admin');
Route::post('/perbandingan', [PerbandinganController::class, 'perbandingan'])->name('perbandingan.post');
Route::post('/perbandingan/ajax', [YajraPerbandinganController::class, 'tampil_data'])->name('perbandingan.ajax');
Route::post('/perbandingan/create', [PerbandinganController::class, 'proses_create'])->name('perbandingan.proses_create');
Route::get('/perbandingan/{id}/detail', [PerbandinganController::class, 'detail'])->name('perbandingan.detail')->middleware('admin');
Route::post('/perbandingan/detail/initiate/ajax', [YajraPerbandinganController::class, 'tampil_data_detail_initiate'])->name('perbandingan.detail.initiate.ajax');
Route::post('/perbandingan/detail/reach/ajax', [YajraPerbandinganController::class, 'tampil_data_detail_reach'])->name('perbandingan.detail.reach.ajax');
Route::post('/perbandingan/detail/videoview/ajax', [YajraPerbandinganController::class, 'tampil_data_detail_videoview'])->name('perbandingan.detail.videoview.ajax');
Route::post('/perbandingan/detail/gmv/ajax', [YajraPerbandinganController::class, 'tampil_data_detail_gmv'])->name('perbandingan.detail_gmv.ajax');
Route::get('/perbandingan/{id}/cetak', [PerbandinganController::class, 'cetak'])->name('perbandingan.cetak');
Route::post('/perbandingan/{id}/update', [PerbandinganController::class, 'update'])->name('perbandingan.update');
Route::delete('/perbandingan/{id}', [PerbandinganController::class, 'hapus'])->name('perbandingan.hapus');

Route::get('/perbandingan/{id}/share', [PerbandinganController::class, 'share'])->name('perbandingan.share');


// logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login.form');
})->name('logout')->middleware('auth');
