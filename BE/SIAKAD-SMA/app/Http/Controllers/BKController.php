<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BKController extends Controller
{
    /**
     * Display BK dashboard
     */
    public function dashboard() {
        return view('bk.dashboard');
    }

    /**
     * Display validasi page
     */
    public function validasi() {
        return view('bk.validasi');
    }

    /**
     * Display surat pemanggilan page
     */
    public function suratPemanggilan() {
        return view('bk.surat-pemanggilan');
    }

    /**
     * Display feedback page
     */
    public function feedback() {
        return view('bk.feedback');
    }

    /**
     * Display laporan page
     */
    public function laporan() {
        return view('bk.laporan');
    }
}
