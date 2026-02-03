<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }
    public function guru() {
        $guru = Guru::all();
        return view('admin.guru', compact('guru'));
    }
    public function kelas() {
        $kelas = Kelas::all();
        return view('admin.kelas', compact('kelas'));
    }
    public function mapel() {
        $mapel = Mapel::all();
        return view('admin.mapel', compact('mapel'));
    }
    public function siswa() {
        $siswa = Siswa::all();
        return view('admin.siswa', compact('siswa'));
    }

}
