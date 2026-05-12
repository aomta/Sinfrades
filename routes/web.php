<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InfrastrukturController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProfileController;


use Illuminate\Support\Facades\Artisan;

Route::get('/migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migration berhasil';
});

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('landing');
});

/*
|--------------------------------------------------------------------------
| Semua route di bawah ini wajib login (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // =============================================
    // DASHBOARD
    // =============================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // =============================================
    // PROFIL
    // =============================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =============================================
    // PETA (semua role)
    // =============================================
    Route::get('/peta', [MapController::class, 'index'])->name('peta.index');
    Route::get('/peta/data', [MapController::class, 'data'])->name('peta.data');

    // =============================================
    // INFRASTRUKTUR
    // Warga           : index, show
    // Admin & Petugas : + create, store, edit, update
    // Admin only      : destroy
    // =============================================
    Route::resource('infrastruktur', InfrastrukturController::class);

    // =============================================
// LAPORAN KERUSAKAN
// =============================================
Route::middleware('auth')->group(function () {
    
    // ADMIN & PETUGAS
    Route::middleware('role:admin,petugas')->group(function () {

        Route::get('/laporan-kerusakan/{laporan_kerusakan}/verifikasi',
            [LaporanController::class, 'verifikasi']
        )->name('laporan.admin.verifikasi');

        Route::put('/laporan-kerusakan/{laporan_kerusakan}/status',
            [LaporanController::class, 'updateStatus']
        )->name('laporan.admin.updateStatus');

    });

    // USER (SEMUA ROLE)
    Route::resource('laporan-kerusakan', LaporanController::class)->names([
        'index'   => 'laporan.user.index',
        'create'  => 'laporan.user.create',
        'store'   => 'laporan.user.store',
        'show'    => 'laporan.user.show',   
        'edit'    => 'laporan.user.edit',
        'update'  => 'laporan.user.update',
        'destroy' => 'laporan.user.destroy',
    ]);


});

    // =============================================
    // PENGAJUAN PEMBANGUNAN
    // Semua role  : index, create, store, show, edit, update, destroy
    //               (pembatasan warga ditangani di dalam controller)
    // Admin only  : updateStatus
    // =============================================
    Route::resource('pengajuan', PengajuanController::class);

    Route::put('/pengajuan/{pengajuan}/status', [PengajuanController::class, 'updateStatus'])
        ->name('pengajuan.updateStatus')
        ->middleware('role:admin');

    // =============================================
    // MAINTENANCE (Admin & Petugas only)
    // =============================================
    Route::resource('maintenance', MaintenanceController::class)
        ->middleware('role:admin,petugas');

    // =============================================
    // ANGGARAN (Admin only)
    // =============================================
    Route::resource('anggaran', AnggaranController::class)
        ->middleware('role:admin');

    // =============================================
    // EXPORT (Admin only)
    // =============================================
    Route::middleware('role:admin')->prefix('export')->name('export.')->group(function () {
        Route::get('/pdf', [ExportController::class, 'pdf'])->name('pdf');
        Route::get('/excel', [ExportController::class, 'excel'])->name('excel');
    });
});

require __DIR__ . '/auth.php';