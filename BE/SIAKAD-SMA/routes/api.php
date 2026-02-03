<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\BKController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\MapelController;
use App\Http\Controllers\API\SiswaController;
use App\Http\Controllers\API\GuruController;
use App\Http\Controllers\API\AbsenController;
use App\Http\Controllers\API\AbsensiController;
use App\Http\Controllers\API\PenjadwalanController;
use App\Http\Controllers\API\PointController;
use App\Http\Controllers\API\BimbinganController;

// ========================================
// AUTH ROUTES (Public - No Authentication)
// ========================================
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');

// ========================================
// ADMIN API ROUTES
// ========================================
Route::prefix('admin')->name('api.admin.')->group(function () {
    Route::get('/dashboardAdmin', [AdminController::class, 'dashboardAdmin'])->name('dashboard');
    // Add more admin API endpoints here
});

// ========================================
// GURU API ROUTES
// ========================================
Route::prefix('guru')->name('api.guru.')->group(function () {
    // Add guru API endpoints here
});

// ========================================
// BK API ROUTES
// ========================================
Route::prefix('bk')->name('api.bk.')->group(function () {
    // Add BK API endpoints here
});

// ========================================
// SISWA API ROUTES
// ========================================
Route::prefix('siswa')->name('api.siswa.')->group(function () {
    // Add siswa API endpoints here
});

// ========================================
// PROTECTED ROUTES (Require Authentication)
// ========================================
Route::middleware('auth:sanctum')->group(function () {
    // Role Management
    Route::apiResource('roles', RoleController::class);
    
    // Kelas Management
    Route::apiResource('kelas', KelasController::class);
    
    // Mata Pelajaran Management
    Route::apiResource('mapel', MapelController::class);
    
    // Siswa Management
    Route::apiResource('siswa', SiswaController::class);
    
    // Guru Management
    Route::apiResource('guru', GuruController::class);
    
    // Absen Management
    Route::apiResource('absen', AbsenController::class);
    
    // Absensi Management
    Route::apiResource('absensi', AbsensiController::class);
    
    // Penjadwalan Management
    Route::apiResource('penjadwalan', PenjadwalanController::class);
    
    // Point Management
    Route::apiResource('point', PointController::class);
    
    // Bimbingan Management
    Route::apiResource('bimbingan', BimbinganController::class);
    
    // BK Management
    Route::apiResource('bk', BKController::class);
});



