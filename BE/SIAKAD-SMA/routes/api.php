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
use App\Http\Controllers\API\JadwalPelajaranController;
use App\Http\Controllers\API\PelanggaranSiswaController;

// ========================================
// AUTH ROUTES (Public - No Authentication)
// ========================================
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');

// ========================================
// PROTECTED ROUTES (Require Authentication)
// ========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    
    // ========================================
    // ADMIN ROUTES - Only accessible by Admin
    // ========================================
    Route::middleware('role:Admin')->prefix('admin')->name('api.admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboardAdmin'])->name('dashboard');
        
        // Kelola Guru
        Route::apiResource('guru', GuruController::class);
        Route::post('guru/{guru}/mapel', [GuruController::class, 'assignMapel'])->name('guru.assign.mapel');
        
        // Kelola Siswa
        Route::apiResource('siswa', SiswaController::class);
        
        // Kelola Mata Pelajaran
        Route::apiResource('mapel', MapelController::class);
        
        // Kelola BK
        Route::apiResource('bk', BKController::class);
        
        // Kelola Kelas
        Route::apiResource('kelas', KelasController::class);
        
        // Kelola Jadwal Pelajaran
        Route::apiResource('jadwal-pelajaran', JadwalPelajaranController::class);
        
        // Kelola Point
        Route::apiResource('point', PointController::class);
        
        // Role Management
        Route::apiResource('roles', RoleController::class);
    });

    // ========================================
    // GURU ROUTES - Only accessible by Guru
    // ========================================
    Route::middleware('role:Guru')->prefix('guru')->name('api.guru.')->group(function () {
        // Jadwal Mengajar Saya
        Route::get('/jadwal-saya/{guru_id}', [JadwalPelajaranController::class, 'getJadwalGuru'])->name('jadwal.saya');
        
        // Kelola Absensi Siswa
        Route::apiResource('absen', AbsenController::class);
        Route::apiResource('absensi', AbsensiController::class);
        
        // Lihat Jadwal Pelajaran
        Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index'])->name('jadwal.index');
    });

    // ========================================
    // BK ROUTES - Only accessible by BK
    // ========================================
    Route::middleware('role:BK')->prefix('bk')->name('api.bk.')->group(function () {
        // Kelola Penjadwalan Konseling
        Route::apiResource('penjadwalan', PenjadwalanController::class);
        
        // Kelola Bimbingan
        Route::apiResource('bimbingan', BimbinganController::class);
        
        // Kelola Pelanggaran Siswa
        Route::apiResource('pelanggaran-siswa', PelanggaranSiswaController::class);
        Route::get('/siswa-bermasalah', [PelanggaranSiswaController::class, 'getSiswaBermasalah'])->name('siswa.bermasalah');
        Route::get('/total-point-siswa/{siswa_id}', [PelanggaranSiswaController::class, 'getTotalPointSiswa'])->name('total.point');
        
        // Lihat Point (Read Only)
        Route::get('/point', [PointController::class, 'index'])->name('point.index');
    });

    // ========================================
    // SISWA ROUTES - Only accessible by Siswa
    // ========================================
    Route::middleware('role:Siswa')->prefix('siswa')->name('api.siswa.')->group(function () {
        // Jadwal Pelajaran Kelas Saya
        Route::get('/jadwal-kelas/{kelas_id}', [JadwalPelajaranController::class, 'getJadwalByKelas'])->name('jadwal.kelas');
        
        // Riwayat Absensi Saya
        Route::get('/absensi-saya/{siswa_id}', [AbsensiController::class, 'getAbsensiSiswa'])->name('absensi.saya');
        
        // Point & Pelanggaran Saya
        Route::get('/pelanggaran-saya/{siswa_id}', [PelanggaranSiswaController::class, 'getTotalPointSiswa'])->name('pelanggaran.saya');
        
        // Jadwal Konseling Saya
        Route::get('/penjadwalan-saya/{siswa_id}', [PenjadwalanController::class, 'getPenjadwalanSiswa'])->name('penjadwalan.saya');
    });

    // ========================================
    // SHARED ROUTES - Accessible by multiple roles
    // ========================================
    
    // Jadwal Pelajaran (Read Only) - Accessible by Admin, Guru, Siswa
    Route::middleware('role:Admin,Guru,Siswa')->group(function () {
        Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index'])->name('api.jadwal.index');
        Route::get('/jadwal-pelajaran/{id}', [JadwalPelajaranController::class, 'show'])->name('api.jadwal.show');
    });
});



