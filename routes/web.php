<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IzinCutiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        if (auth()->user()->role == 'admin') {
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->route('absensi');
        }
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('izin-cuti', IzinCutiController::class)->only(['index', 'create', 'store']);
    Route::patch('izin-cuti/{izinCuti}/status', [IzinCutiController::class, 'updateStatus'])
        ->name('izin-cuti.update-status');
});
// Hanya Admin
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan');
    Route::resource('shifts', ShiftController::class);
    Route::delete('shifts/karyawan/{karyawanShift}', [ShiftController::class, 'destroyKaryawanShift'])
        ->name('shifts.destroyKaryawanShift');
    Route::post('shifts/assign', [ShiftController::class, 'assignShift'])->name('shifts.assign');
});

// Hanya Karyawan
Route::middleware(['auth', 'verified', 'role:karyawan'])->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
    Route::post('/absensi/check-in', [AbsensiController::class, 'checkIn'])->name('absensi.checkin');
    Route::post('/absensi/check-out', [AbsensiController::class, 'checkOut'])->name('absensi.checkout');
});

require __DIR__ . '/auth.php';
