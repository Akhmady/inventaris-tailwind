<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\Pengaturan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Riwayat;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Rute Halaman Utama




Route::get('/riwayat', [Riwayat::class, 'index'])->name('riwayat');
Route::get ('/pengaturan', [Pengaturan::class, 'index'])->name('pengaturan');



// Rute Login dan Autentikasi

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Rute Dashboard
Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
Route::get('/dashboard/chart', [Dashboard::class, 'chart'])->name('dashboard.chart');

// Ruangan


Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan');
Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
Route::get('/ruangan{id}',[RuanganController::class, 'show'])->name('ruangan.show');

// Aset

Route::get('/aset', [AsetController::class, 'index'])->name('aset');
Route::get('/aset/create', [AsetController::class, 'create'])->name('aset.create');
Route::post('/aset', [AsetController::class, 'store'])->name('aset.store');
Route::get('/aset{id}',[AsetController::class, 'show'])->name('aset.show');


require __DIR__.'/auth.php';
