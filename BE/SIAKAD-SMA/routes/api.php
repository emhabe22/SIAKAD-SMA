<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\BKController;
use App\Http\Controllers\API\MapelController;
use App\Http\Controllers\API\SiswaController;
use App\Http\Controllers\API\GuruController;
use App\Http\Controllers\API\AbsenController;
use App\Http\Controllers\API\AbsensiController;
use App\Http\Controllers\API\PenjadwalanController;
use App\Http\Controllers\API\PointController;
use App\Http\Controllers\API\BimbinganController;
use App\Http\Controllers\API\JadwalPelajaranController;
use App\Http\Controllers\API\JadwalSlotController;
use App\Http\Controllers\API\PelanggaranSiswaController;
use App\Http\Controllers\API\LogbookMengajarController;

// ========================================
// AUTH ROUTES (Public - No Authentication)
// ========================================
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// ========================================
// PROTECTED ROUTES (Require Authentication)
// ========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // Get current user profile
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');
    
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

        // Kelola Jadwal Pelajaran
        Route::post('jadwal-pelajaran/bulk', [JadwalPelajaranController::class, 'bulkStore'])->name('jadwal-pelajaran.bulk');
        Route::apiResource('jadwal-pelajaran', JadwalPelajaranController::class);

        // Kelola Point
        Route::apiResource('point', PointController::class);

        // Role Management
        Route::apiResource('roles', RoleController::class);

        // ── MONITOR ABSENSI (Admin) ──
        // Lihat semua sesi absen (filter: tanggal, guru_id, tingkat)
        Route::get('/absen', [AbsenController::class, 'index'])->name('absen.index');
        // Detail satu sesi absen + log book
        Route::get('/absen/{id}/detail', [AbsensiController::class, 'getDetailSesi'])->name('absen.detail');
        // Update status absensi siswa (admin)
        Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
        // Rekap absensi per siswa
        Route::get('/rekap-absensi/{siswa_id}', [AbsensiController::class, 'getAbsensiSiswa'])->name('rekap.absensi');

        // ── LOGBOOK GURU (Admin view) ──
        Route::get('/logbook-guru', [LogbookMengajarController::class, 'indexAdmin'])->name('logbook.admin.index');
        Route::get('/logbook-guru/{guru_id}', [LogbookMengajarController::class, 'showByGuru'])->name('logbook.admin.show');
    });

    // ========================================
    // GURU ROUTES - Only accessible by Guru
    // ========================================
    Route::middleware('role:Guru')->prefix('guru')->name('api.guru.')->group(function () {
        // Jadwal Mengajar Saya
        Route::get('/jadwal-saya/{guru_id}', [JadwalPelajaranController::class, 'getJadwalGuru'])->name('jadwal.saya');

        // Ambil mapel milik guru yang login (untuk prefill form absen)
        Route::get('/mapel-saya', [AbsenController::class, 'getMapelGuru'])->name('mapel.saya');

        // Ambil siswa berdasarkan tingkat (untuk checklist absensi)
        Route::get('/siswa-tingkat/{tingkat}', [AbsenController::class, 'getSiswaByTingkat'])->name('siswa.tingkat');

        // Riwayat sesi absen milik guru ini
        Route::get('/absen-saya', [AbsenController::class, 'getAbsenGuru'])->name('absen.saya');

        // CRUD sesi absen
        Route::apiResource('absen', AbsenController::class);

        // Detail satu sesi absen (info + daftar siswa + log book)
        Route::get('/absen/{id}/detail', [AbsensiController::class, 'getDetailSesi'])->name('absen.detail');

        // Simpan sesi absen + absensi semua siswa sekaligus (1 klik)
        Route::post('/absensi/bulk', [AbsensiController::class, 'bulkStore'])->name('absensi.bulk');

        // Update status absen satu siswa (dengan log book otomatis)
        Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');

        // Lihat Jadwal Pelajaran
        Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index'])->name('jadwal.index');

        // ── LOGBOOK MENGAJAR ──
        Route::get('/logbook', [LogbookMengajarController::class, 'index'])->name('logbook.index');
        Route::get('/logbook/{id}', [LogbookMengajarController::class, 'show'])->name('logbook.show');
        Route::put('/logbook/{id}', [LogbookMengajarController::class, 'update'])->name('logbook.update');
        Route::post('/logbook/{id}/serahkan', [LogbookMengajarController::class, 'serahkan'])->name('logbook.serahkan');
    });

    // ========================================
    // BK ROUTES - Only accessible by BK
    // ========================================
    Route::middleware('role:BK')->prefix('bk')->name('api.bk.')->group(function () {
        // Kelola Penjadwalan Konseling
        Route::apiResource('penjadwalan', PenjadwalanController::class);
        Route::post('/penjadwalan/{id}/approve', [PenjadwalanController::class, 'approve'])->name('penjadwalan.approve');
        Route::post('/penjadwalan/{id}/reject', [PenjadwalanController::class, 'reject'])->name('penjadwalan.reject');
        
        // Kelola Bimbingan
        Route::apiResource('bimbingan', BimbinganController::class);
        
        // Kelola Pelanggaran Siswa
        Route::apiResource('pelanggaran-siswa', PelanggaranSiswaController::class);
        Route::get('/siswa-bermasalah', [PelanggaranSiswaController::class, 'getSiswaBermasalah'])->name('siswa.bermasalah');
        Route::get('/total-point-siswa/{siswa_id}', [PelanggaranSiswaController::class, 'getTotalPointSiswa'])->name('total.point');
        
        // Lihat Data Siswa (Read Only)
        Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
        
        // Lihat Point (Read Only)
        Route::get('/point', [PointController::class, 'index'])->name('point.index');
    });

    // ========================================
    // SISWA ROUTES - Only accessible by Siswa
    // ========================================
    Route::middleware('role:Siswa')->prefix('siswa')->name('api.siswa.')->group(function () {
        // Jadwal Pelajaran Tingkat Saya
        Route::get('/jadwal-tingkat/{tingkat}', [JadwalPelajaranController::class, 'getJadwalByTingkat'])->name('jadwal.tingkat');

        // Riwayat Absensi Saya (grouped by mapel + persentase)
        Route::get('/absensi-saya/{siswa_id}', [AbsensiController::class, 'getAbsensiSiswa'])->name('absensi.saya');

        // Point & Pelanggaran Saya
        Route::get('/pelanggaran-saya/{siswa_id}', [PelanggaranSiswaController::class, 'getTotalPointSiswa'])->name('pelanggaran.saya');

        // Lihat Data BK (Read Only)
        Route::get('/bk', [BKController::class, 'index'])->name('bk.index');

        // Jadwal Konseling Saya
        Route::get('/penjadwalan-saya/{siswa_id}', [PenjadwalanController::class, 'getPenjadwalanSiswa'])->name('penjadwalan.saya');

        // Ajukan Jadwal Konseling
        Route::post('/penjadwalan', [PenjadwalanController::class, 'store'])->name('penjadwalan.store');

        // Batalkan Jadwal Konseling
        Route::delete('/penjadwalan/{id}', [PenjadwalanController::class, 'destroy'])->name('penjadwalan.destroy');
    });

    // ========================================
    // SHARED ROUTES - Accessible by multiple roles
    // ========================================

    Route::get('/jadwal-slots', [JadwalSlotController::class, 'index'])->name('api.jadwal-slots.index');
    
    // Jadwal Pelajaran (Read Only) - Accessible by Admin, Guru, Siswa
    Route::middleware('role:Admin,Guru,Siswa')->group(function () {
        Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index'])->name('api.jadwal.index');
        Route::get('/jadwal-pelajaran/{id}', [JadwalPelajaranController::class, 'show'])->name('api.jadwal.show');
    });
});



