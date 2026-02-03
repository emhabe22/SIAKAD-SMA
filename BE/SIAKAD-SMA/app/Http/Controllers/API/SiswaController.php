<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    // Tampilkan semua siswa
    public function index()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        return response()->json([
            'success' => true,
            'data' => $siswas
        ]);
    }

    // Tambah siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nisn' => 'required|unique:siswas',
            'alamat' => 'required|string',
            'no_telp' => 'required|integer',
            'kelas_id' => 'required|exists:kelas,id',
            'nama_wali' => 'required|string',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        // Buat user dulu
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nisn' => $request->nisn,
            'role_id' => 4, // role siswa
        ]);

        // Buat siswa
        $siswa = Siswa::create([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'kelas_id' => $request->kelas_id,
            'nama_wali' => $request->nama_wali,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil ditambahkan',
            'data' => $siswa->load(['user', 'kelas'])
        ], 201);
    }

    // Tampilkan satu siswa
    public function show($id)
    {
        $siswa = Siswa::with(['user', 'kelas'])->find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $siswa
        ]);
    }

    // Update siswa
    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama' => 'required|string',
            'nisn' => 'required|unique:siswas,nisn,' . $id,
            'alamat' => 'required|string',
            'no_telp' => 'required|integer',
            'kelas_id' => 'required|exists:kelas,id',
            'nama_wali' => 'required|string',
        ]);

        $siswa->update($request->only(['nama', 'nisn', 'alamat', 'no_telp', 'kelas_id', 'nama_wali']));

        // Update user nisn
        $siswa->user->update(['nisn' => $request->nisn]);

        // Update password jika ada
        if ($request->password) {
            $siswa->user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil diupdate',
            'data' => $siswa->load(['user', 'kelas'])
        ]);
    }

    // Hapus siswa
    public function destroy($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan'
            ], 404);
        }

        $siswa->user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil dihapus'
        ]);
    }
}
