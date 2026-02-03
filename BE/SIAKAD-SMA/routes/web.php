<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\BKController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

// ========================================
// PUBLIC ROUTES
// ========================================
Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ========================================
// ADMIN ROUTES
// ========================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/siswa', [AdminController::class, 'siswa'])->name('siswa');
    Route::get('/guru', [AdminController::class, 'guru'])->name('guru');
    Route::get('/kelas', [AdminController::class, 'kelas'])->name('kelas');
    Route::get('/mapel', [AdminController::class, 'mapel'])->name('mapel');
    Route::get('/jadwal-bk', [AdminController::class, 'jadwalBk'])->name('jadwal-bk');
});

// ========================================
// GURU ROUTES
// ========================================
Route::prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::get('/jadwal-mengajar', [GuruController::class, 'jadwalMengajar'])->name('jadwal-mengajar');
    Route::get('/absensi', [GuruController::class, 'absensi'])->name('absensi');
    Route::get('/logbook', [GuruController::class, 'logbook'])->name('logbook');
});

// ========================================
// BK ROUTES
// ========================================
Route::prefix('bk')->name('bk.')->group(function () {
    Route::get('/dashboard', [BKController::class, 'dashboard'])->name('dashboard');
    Route::get('/validasi', [BKController::class, 'validasi'])->name('validasi');
    Route::get('/surat-pemanggilan', [BKController::class, 'suratPemanggilan'])->name('surat-pemanggilan');
    Route::get('/feedback', [BKController::class, 'feedback'])->name('feedback');
    Route::get('/laporan', [BKController::class, 'laporan'])->name('laporan');
});

// ========================================
// SISWA ROUTES
// ========================================
Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/absensi', [SiswaController::class, 'absensi'])->name('absensi');
    Route::get('/bk', [SiswaController::class, 'bk'])->name('bk');
    Route::get('/surat-pemanggilan', [SiswaController::class, 'suratPemanggilan'])->name('surat-pemanggilan');
});



