<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    // Tampilkan semua guru
    public function index()
    {
        $gurus = Guru::with(['user', 'mapels'])->get();
        return response()->json([
            'success' => true,
            'data' => $gurus
        ]);
    }

    // Tambah guru baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'nip' => 'required|unique:gurus',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'jabatan' => 'required|array',
            'jabatan.*' => 'required|in:Guru Mata Pelajaran,Kepala Sekolah,Wali Kelas,Guru BK',
            'mapel_ids' => 'array',
            'mapel_ids.*' => 'exists:mapels,id',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Validasi: Guru BK tidak bisa memiliki jabatan lain
        if (in_array('Guru BK', $request->jabatan) && count($request->jabatan) > 1) {
            return response()->json([
                'success' => false,
                'message' => 'Guru BK tidak dapat memiliki jabatan lain'
            ], 422);
        }

        // Tentukan role_id berdasarkan jabatan
        $roleId = in_array('Guru BK', $request->jabatan) ? 2 : 3;

        // Buat user dulu
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id' => $roleId, // role BK (2) atau guru (3)
        ]);

        // Buat guru
        $guru = Guru::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jabatan' => $request->jabatan,
            'user_id' => $user->id,
        ]);

        // Attach mapels if provided
        if ($request->has('mapel_ids')) {
            $guru->mapels()->attach($request->mapel_ids);
        }

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil ditambahkan',
            'data' => $guru->load(['user', 'mapels'])
        ], 201);
    }

    // Tampilkan satu guru
    public function show($id)
    {
        $guru = Guru::with(['user', 'mapels', 'jadwalPelajarans'])->find($id);

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

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|required|string',
            'nip' => 'sometimes|required|unique:gurus,nip,' . $id,
            'alamat' => 'sometimes|required|string',
            'no_telp' => 'sometimes|required|string',
            'jenis_kelamin' => 'sometimes|required|in:L,P',
            'jabatan' => 'sometimes|required|array',
            'jabatan.*' => 'sometimes|required|in:Guru Mata Pelajaran,Kepala Sekolah,Wali Kelas,Guru BK',
            'mapel_ids' => 'array',
            'mapel_ids.*' => 'exists:mapels,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Validasi: Guru BK tidak bisa memiliki jabatan lain
        if ($request->has('jabatan') && in_array('Guru BK', $request->jabatan) && count($request->jabatan) > 1) {
            return response()->json([
                'success' => false,
                'message' => 'Guru BK tidak dapat memiliki jabatan lain'
            ], 422);
        }

        $guru->update($request->only(['nama', 'nip', 'alamat', 'no_telp', 'jenis_kelamin', 'jabatan']));

        // Update role_id jika jabatan berubah
        if ($request->has('jabatan')) {
            $roleId = in_array('Guru BK', $request->jabatan) ? 2 : 3;
            $guru->user->update(['role_id' => $roleId]);
        }

        // Update mapels if provided
        if ($request->has('mapel_ids')) {
            $guru->mapels()->sync($request->mapel_ids);
        }

        // Update password jika ada
        if ($request->password) {
            $guru->user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Guru berhasil diupdate',
            'data' => $guru->load(['user', 'mapels'])
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

    /**
     * Assign mapel to guru
     */
    public function assignMapel(Request $request, $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'mapel_ids' => 'required|array',
            'mapel_ids.*' => 'exists:mapels,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $guru->mapels()->sync($request->mapel_ids);
        $guru->load('mapels');

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil di-assign ke guru',
            'data' => $guru
        ]);
    }
}
