<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard() {
        return view('admin.dashboard');
    }

    /**
     * Display data siswa page
     */
    public function siswa() {
        return view('admin.siswa');
    }

    /**
     * Display data guru page
     */
    public function guru() {
        return view('admin.guru');
    }

    /**
     * Display mata pelajaran page
     */
    public function mapel() {
        return view('admin.mata-pelajaran');
    }

    /**
     * Display jadwal BK page
     */
    public function jadwalBk() {
        return view('admin.jadwal-bk');
    }

    /**
     * Display jadwal pelajaran page
     */
    public function jadwalPelajaran() {
        return view('admin.jadwal-pelajaran');
    }

    public function jadwalMaster()
    {
        return view('admin.jadwal-master');
    }

    /**
     * Display halaman logbook guru (laporan)
     */
    public function logbook() {
        return view('admin.logbook');
    }
}
