<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // Tampilkan semua guru
    public function index()
    {
        $gurus = Guru::with(['user', 'mapel'])->get();
        return response()->json([
            'success' => true,
            'data' => $gurus
        ]);
    }

    // Tambah guru baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nip' => 'required|unique:gurus',
            'alamat' => 'required|string',
            'no_telp' => 'required|integer',
            'mapel_id' => 'required|exists:mapels,id',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        // Buat user dulu
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'role_id' => 2, // role guru
        ]);

        // Buat guru
        $guru = Guru::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'mapel_id' => $request->mapel_id,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil ditambahkan',
            'data' => $guru->load(['user', 'mapel'])
        ], 201);
    }

    // Tampilkan satu guru
    public function show($id)
    {
        $guru = Guru::with(['user', 'mapel'])->find($id);

        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $guru
        ]);
    }

    // Update guru
    public function update(Request $request, $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama' => 'required|string',
            'nip' => 'required|unique:gurus,nip,' . $id,
            'alamat' => 'required|string',
            'no_telp' => 'required|integer',
            'mapel_id' => 'required|exists:mapels,id',
        ]);

        $guru->update($request->only(['nama', 'nip', 'alamat', 'no_telp', 'mapel_id']));

        // Update user nip
        $guru->user->update(['nip' => $request->nip]);

        // Update password jika ada
        if ($request->password) {
            $guru->user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil diupdate',
            'data' => $guru->load(['user', 'mapel'])
        ]);
    }

    // Hapus guru
    public function destroy($id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan'
            ], 404);
        }

        $guru->user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil dihapus'
        ]);
    }
}
