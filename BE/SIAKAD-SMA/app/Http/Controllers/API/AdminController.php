<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function dashboardAdmin()
    {
        $admins = Admin::with('user')->get();
        $gurus = Guru::all();
        $siswas = Siswa::all();
        $kelas = Kelas::all();
        $mapel = Mapel::all();
        return response()->json([
            'success' => true,
            'data' => [
                'admins' => $admins,
                'gurus' => $gurus,
                'siswas' => $siswas,
                'kelas' => $kelas,
                'mapel' => $mapel
            ]
        ]);
    }

    // Tambah admin baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'no_telp' => 'required|string',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        // Buat user dulu
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => 3, // role admin
        ]);

        // Buat admin
        $admin = Admin::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil ditambahkan',
            'data' => $admin->load('user')
        ], 201);
    }

    // Tampilkan satu admin
    public function show($id)
    {
        $admin = Admin::with('user')->find($id);

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $admin
        ]);
    }

    // Update admin
    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama' => 'required|string',
            'no_telp' => 'required|string',
        ]);

        $admin->update($request->only(['nama', 'no_telp']));

        // Update password jika ada
        if ($request->password) {
            $admin->user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil diupdate',
            'data' => $admin->load('user')
        ]);
    }

    // Hapus admin
    public function destroy($id)
    {
        $admin = Admin::find($id);

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'Admin tidak ditemukan'
            ], 404);
        }

        $admin->user->delete(); // akan cascade delete admin

        return response()->json([
            'success' => true,
            'message' => 'Admin berhasil dihapus'
        ]);
    }
}
