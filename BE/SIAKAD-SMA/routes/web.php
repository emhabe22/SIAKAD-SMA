<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', [IndexController::class, 'index']);
Route::get('/login', [IndexController::class, 'login']);


//ADMIN
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index']);
        Route::get('/siswa', [AdminController::class, 'siswa']);
        Route::get('/guru', [AdminController::class, 'guru']);
        Route::get('/kelas', [AdminController::class, 'kelas']);
        Route::get('/mata-pelajaran', [AdminController::class, 'mapel']);
        Route::get('/jadwal-bk', [AdminController::class, 'jadwal_bk']);
    });


