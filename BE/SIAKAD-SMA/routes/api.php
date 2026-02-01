<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BKController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PenjadwalanController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\BimbinganController;

// ========================================
// AUTH ROUTES (Tanpa auth)
// ========================================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ========================================
// PROTECTED ROUTES (Perlu login)
// ========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Roles
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'destroy']);
    
    // Admins
    Route::get('/admins', [AdminController::class, 'index']);
    Route::post('/admins', [AdminController::class, 'store']);
    Route::get('/admins/{id}', [AdminController::class, 'show']);
    Route::put('/admins/{id}', [AdminController::class, 'update']);
    Route::delete('/admins/{id}', [AdminController::class, 'destroy']);
    
    // BK (Bimbingan Konseling)
    Route::get('/bk', [BKController::class, 'index']);
    Route::post('/bk', [BKController::class, 'store']);
    Route::get('/bk/{id}', [BKController::class, 'show']);
    Route::put('/bk/{id}', [BKController::class, 'update']);
    Route::delete('/bk/{id}', [BKController::class, 'destroy']);
    
    // Kelas
    Route::get('/kelas', [KelasController::class, 'index']);
    Route::post('/kelas', [KelasController::class, 'store']);
    Route::get('/kelas/{id}', [KelasController::class, 'show']);
    Route::put('/kelas/{id}', [KelasController::class, 'update']);
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy']);
    
    // Mapel (Mata Pelajaran)
    Route::get('/mapels', [MapelController::class, 'index']);
    Route::post('/mapels', [MapelController::class, 'store']);
    Route::get('/mapels/{id}', [MapelController::class, 'show']);
    Route::put('/mapels/{id}', [MapelController::class, 'update']);
    Route::delete('/mapels/{id}', [MapelController::class, 'destroy']);
    
    // Siswa
    Route::get('/siswas', [SiswaController::class, 'index']);
    Route::post('/siswas', [SiswaController::class, 'store']);
    Route::get('/siswas/{id}', [SiswaController::class, 'show']);
    Route::put('/siswas/{id}', [SiswaController::class, 'update']);
    Route::delete('/siswas/{id}', [SiswaController::class, 'destroy']);
    
    // Guru
    Route::get('/gurus', [GuruController::class, 'index']);
    Route::post('/gurus', [GuruController::class, 'store']);
    Route::get('/gurus/{id}', [GuruController::class, 'show']);
    Route::put('/gurus/{id}', [GuruController::class, 'update']);
    Route::delete('/gurus/{id}', [GuruController::class, 'destroy']);
    
    // Absen
    Route::get('/absens', [AbsenController::class, 'index']);
    Route::post('/absens', [AbsenController::class, 'store']);
    Route::get('/absens/{id}', [AbsenController::class, 'show']);
    Route::put('/absens/{id}', [AbsenController::class, 'update']);
    Route::delete('/absens/{id}', [AbsenController::class, 'destroy']);
    
    // Absensi
    Route::get('/absensis', [AbsensiController::class, 'index']);
    Route::post('/absensis', [AbsensiController::class, 'store']);
    Route::get('/absensis/{id}', [AbsensiController::class, 'show']);
    Route::put('/absensis/{id}', [AbsensiController::class, 'update']);
    Route::delete('/absensis/{id}', [AbsensiController::class, 'destroy']);
    
    // Penjadwalan
    Route::get('/penjadwalans', [PenjadwalanController::class, 'index']);
    Route::post('/penjadwalans', [PenjadwalanController::class, 'store']);
    Route::get('/penjadwalans/{id}', [PenjadwalanController::class, 'show']);
    Route::put('/penjadwalans/{id}', [PenjadwalanController::class, 'update']);
    Route::delete('/penjadwalans/{id}', [PenjadwalanController::class, 'destroy']);
    
    // Points
    Route::get('/points', [PointController::class, 'index']);
    Route::post('/points', [PointController::class, 'store']);
    Route::get('/points/{id}', [PointController::class, 'show']);
    Route::put('/points/{id}', [PointController::class, 'update']);
    Route::delete('/points/{id}', [PointController::class, 'destroy']);
    
    // Bimbingan
    Route::get('/bimbingans', [BimbinganController::class, 'index']);
    Route::post('/bimbingans', [BimbinganController::class, 'store']);
    Route::get('/bimbingans/{id}', [BimbinganController::class, 'show']);
    Route::put('/bimbingans/{id}', [BimbinganController::class, 'update']);
    Route::delete('/bimbingans/{id}', [BimbinganController::class, 'destroy']);
});
