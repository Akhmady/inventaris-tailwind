<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AsetRuanganController;
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


Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
    Route::get('/', [PengaturanController::class, 'index'])->name('index');
    Route::post('/update-name', [PengaturanController::class, 'updateName'])->name('updateName');
});


// Rute Login dan Autentikasi

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Rute Dashboard
Route::get('/dashboard', [Dashboard::class, 'index'])->name('dashboard');
Route::get('/dashboard/chart', [Dashboard::class, 'chart'])->name('dashboard.chart');

// Ruangan


Route::resource('ruangan', RuanganController::class);

Route::prefix('ruangan')->name('ruangan.')->group(function () {
    Route::get('/', [RuanganController::class, 'index'])->name('index');
    Route::get('/create', [RuanganController::class, 'create'])->name('create');
    Route::post('/', [RuanganController::class, 'store'])->name('store');
    Route::get('/{id}', [RuanganController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [RuanganController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RuanganController::class, 'update'])->name('update');
    Route::get('/{id}/delete', [RuanganController::class, 'deleteConfirm'])->name('deleteConfirm');
    Route::delete('/{id}', [RuanganController::class, 'destroy'])->name('destroy');
    Route::get('/search', [RuanganController::class, 'search'])->name('search');

});

// CRUD Aset per Ruangan ( AsetRuangan ) 
Route::prefix('ruangan/{ruangan}')->name('ruangan.')->group(function () {

    Route::prefix('aset')->name('aset.')->group(function () {
        Route::get('/create', [AsetRuanganController::class, 'create'])->name('create');
        Route::post('/store', [AsetRuanganController::class, 'store'])->name('store');

        // 🔧 Edit & Update aset grup (nama route diseragamkan)
        Route::get('/group/{aset}/{kondisi}/edit', [AsetRuanganController::class, 'editGroup'])
            ->where(['aset' => '[0-9]+', 'kondisi' => '.*'])
            ->name('edit');

        Route::put('/group/{aset}/{kondisi}', [AsetRuanganController::class, 'updateGroup'])
            ->where(['aset' => '[0-9]+', 'kondisi' => '.*'])
            ->name('update');

        // 🔧 Hapus aset ruangan per ID
        Route::delete('/{id}', [AsetRuanganController::class, 'destroy'])
        ->where('id', '[0-9]+')
        ->name('destroy');
    });
});




// Aset Master

Route::resource('aset', AsetController::class);

Route::prefix('aset')->name('aset.')->group(function () {
    Route::get('/', [AsetController::class, 'index'])->name('index');
    Route::get('/create', [AsetController::class, 'create'])->name('create');
    Route::post('/', [AsetController::class, 'store'])->name('store');
    Route::get('/{id}', [AsetController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [AsetController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AsetController::class, 'update'])->name('update');
    Route::get('/{id}/delete', [AsetController::class, 'deleteConfirm'])->name('delete');
    Route::delete('/{id}', [AsetController::class, 'destroy'])->name('destroy');
});




require __DIR__.'/auth.php';
