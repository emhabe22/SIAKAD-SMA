<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display siswa dashboard
     */
    public function dashboard() {
        return view('siswa.dashboard');
    }

    /**
     * Display absensi page
     */
    public function absensi() {
        return view('siswa.absensi');
    }

    /**
     * Display BK page
     */
    public function bk() {
        return view('siswa.bk');
    }

    /**
     * Display surat pemanggilan page
     */
    public function suratPemanggilan() {
        return view('siswa.surat-pemanggilan');
    }
}
