<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display login page
     */
    public function showLogin() {
        return view('login');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request) {
        // Clear session/token if needed
        return redirect('/login');
    }
}
