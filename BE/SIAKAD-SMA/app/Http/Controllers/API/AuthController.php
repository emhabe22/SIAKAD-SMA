<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $loginField = $request->username;
        
        // Check if login field is email, NISN, or username
        $user = null;
        
        // Try to find by NISN (for students)
        if (!$user) {
            $user = User::with('role')->where('nisn', $loginField)->first();
        }
        
        // Try to find by email (search in siswa table)
        if (!$user) {
            $siswa = \App\Models\Siswa::where('email', $loginField)->first();
            if ($siswa) {
                $user = $siswa->user;
                $user->load('role'); // Load the role relation
            }
        }
        
        // Try to find by username (for all users including admin, guru, BK)
        if (!$user) {
            $user = User::with('role')->where('username', $loginField)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username/NISN/Email atau password salah'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'token' => $token,
                'redirect_url' => match ($user->role->name) {
                    'Admin' => '/admin/dashboard',
                    'Guru'  => '/guru/dashboard',
                    'Siswa' => '/siswa/dashboard',
                    'BK'    => '/bk/dashboard',
                    default => '/login'
                }
            ]
        ]);

    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    // Get user yang sedang login
    public function me(Request $request)
    {
        $user = $request->user()->load('role');
        
        // Load additional data based on role
        $additionalData = null;
        switch ($user->role->name) {
            case 'Siswa':
                $additionalData = \App\Models\Siswa::where('user_id', $user->id)->first();
                break;
            case 'Guru':
                $additionalData = \App\Models\Guru::where('user_id', $user->id)->with('mapels')->first();
                break;
            case 'BK':
                $additionalData = \App\Models\BK::where('user_id', $user->id)->first();
                break;
            case 'Admin':
                $additionalData = \App\Models\Admin::where('user_id', $user->id)->first();
                break;
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'profile' => $additionalData
            ]
        ]);
    }
}
