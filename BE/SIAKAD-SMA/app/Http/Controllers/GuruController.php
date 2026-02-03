<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Display guru dashboard
     */
    public function dashboard() {
        return view('guru.dashboard');
    }

    /**
     * Display jadwal mengajar page
     */
    public function jadwalMengajar() {
        return view('guru.jadwal-mengajar');
    }

    /**
     * Display absensi page
     */
    public function absensi() {
        return view('guru.absensi');
    }

    /**
     * Display logbook page
     */
    public function logbook() {
        return view('guru.logbook');
    }
}
