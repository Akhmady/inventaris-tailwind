<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    DashboardController,
    RuanganController,
    AsetController,
    PengaturanController,
    AuthController,
    AsetRuanganController
};
use App\Http\Controllers\ActivityLogController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| File ini berisi seluruh routing utama aplikasi.
| Struktur diatur agar tetap aman, konsisten, dan mudah dikembangkan.
| Seluruh fitur utama dibungkus middleware `auth` agar hanya user login
| yang dapat mengaksesnya (penting untuk Activity Log).
|
*/

Route::get('/', function () {
    return redirect()->guest(route('login'));
})->middleware('guest');

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

// 🔸 Authentication Routes (Breeze)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

require __DIR__ . '/auth.php';

// 🔒 Seluruh fitur utama hanya untuk user login
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard & Riwayat
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->middleware('auth')->name('dashboard');
    
    Route::get('/dashboard/chart', [DashboardController::class, 'chartData'])
        ->middleware('auth')
        ->name('dashboard.chart');



Route::get('/activitylog', [ActivityLogController::class, 'index'])
    ->name('activitylog.index')
    ->middleware('auth');


    /*
    |--------------------------------------------------------------------------
    | Pengaturan
    |--------------------------------------------------------------------------
    */
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/', [PengaturanController::class, 'index'])->name('index');
        Route::post('/update-name', [PengaturanController::class, 'updateName'])->name('updateName');
    });

    /*
    |--------------------------------------------------------------------------
    | Profile (Breeze Default)
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | CRUD Ruangan
    |--------------------------------------------------------------------------
    |
    | Menangani seluruh operasi CRUD untuk entitas Ruangan.
    | Sudah mencakup fitur pencarian & konfirmasi hapus.
    |
    */
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

    /*
    |--------------------------------------------------------------------------
    | CRUD Aset Ruangan (Aset di dalam Ruangan)
    |--------------------------------------------------------------------------
    |
    | Mengelola relasi antara aset master dan ruangan.
    | Menggunakan route prefix dinamis `ruangan/{ruangan}`.
    |
    */
    Route::prefix('ruangan/{ruangan}')->name('ruangan.')->group(function () {
        Route::prefix('aset')->name('aset.')->group(function () {
            Route::get('/create', [AsetRuanganController::class, 'create'])->name('create');
            Route::post('/store', [AsetRuanganController::class, 'store'])->name('store');

            // Edit grup aset berdasarkan jenis & kondisi
            Route::get('/group/{aset}/{kondisi}/edit', [AsetRuanganController::class, 'editGroup'])
                ->where(['aset' => '[0-9]+', 'kondisi' => '.*'])
                ->name('edit');

            Route::put('/group/{aset}/{kondisi}', [AsetRuanganController::class, 'updateGroup'])
                ->where(['aset' => '[0-9]+', 'kondisi' => '.*'])
                ->name('update');

            // Hapus satuan aset di ruangan
            Route::delete('/{id}', [AsetRuanganController::class, 'destroy'])
                ->where('id', '[0-9]+')
                ->name('destroy');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | CRUD Aset Master
    |--------------------------------------------------------------------------
    |
    | Mengatur aset utama (template aset), bukan yang terhubung ke ruangan.
    |
    */
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

});
