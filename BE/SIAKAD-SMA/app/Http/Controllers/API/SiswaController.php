<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    // Tampilkan semua siswa
    public function index()
    {
        $siswas = Siswa::with(['user'])->get();
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
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string',
            'email' => 'nullable|email',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'tingkat' => 'required|in:X,XI,XII',
            'tahun_masuk' => 'nullable|integer',
            'nama_wali' => 'required|string',
            'nama_ibu' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'telp_ortu' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'password' => 'required|min:6',
        ]);

        // Handle foto upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fotoPath = $file->storeAs('foto_siswa', $filename, 'public');
        }

        // Buat user dulu (username auto-generated dari NISN)
        $user = User::create([
            'username' => $request->nisn, // Username = NISN untuk siswa
            'password' => Hash::make($request->password),
            'nisn' => $request->nisn,
            'role_id' => 4, // role siswa
        ]);

        // Buat siswa
        $siswa = Siswa::create([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'tingkat' => $request->tingkat,
            'tahun_masuk' => $request->tahun_masuk,
            'nama_wali' => $request->nama_wali,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'telp_ortu' => $request->telp_ortu,
            'foto' => $fotoPath,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil ditambahkan',
            'data' => $siswa->load(['user'])
        ], 201);
    }

    // Tampilkan satu siswa
    public function show($id)
    {
        $siswa = Siswa::with(['user'])->find($id);

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
            'nama' => 'sometimes|required|string',
            'nisn' => 'sometimes|required|unique:siswas,nisn,' . $id,
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'agama' => 'nullable|string',
            'email' => 'nullable|email',
            'alamat' => 'sometimes|required|string',
            'no_telp' => 'sometimes|required|string',
            'tingkat' => 'sometimes|required|in:X,XI,XII',
            'tahun_masuk' => 'nullable|integer',
            'nama_wali' => 'sometimes|required|string',
            'nama_ibu' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'telp_ortu' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // Handle foto upload
        $updateData = $request->only([
            'nama', 'nisn', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 
            'agama', 'email', 'alamat', 'no_telp', 'tingkat', 'tahun_masuk',
            'nama_wali', 'nama_ibu', 'pekerjaan_ayah', 'pekerjaan_ibu', 'telp_ortu'
        ]);

        if ($request->hasFile('foto')) {
            // Delete old foto if exists
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $updateData['foto'] = $file->storeAs('foto_siswa', $filename, 'public');
        }

        $siswa->update($updateData);

        // Update user nisn and username (username = NISN for students)
        $siswa->user->update([
            'nisn' => $request->nisn,
            'username' => $request->nisn
        ]);

        // Update password jika ada
        if ($request->password) {
            $siswa->user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Siswa berhasil diupdate',
            'data' => $siswa->load(['user'])
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
