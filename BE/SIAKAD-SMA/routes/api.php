<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\API\AdminController;
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
use App\Http\Controllers\IndexController;

// ========================================
// AUTH ROUTES (Tanpa auth)
// ========================================
Route::post('/login', [AuthController::class, 'login']);

//ADMIN
    Route::get('/admin/dashboardAdmin', [AdminController::class, 'dashboardAdmin']);


