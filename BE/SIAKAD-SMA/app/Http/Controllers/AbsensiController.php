<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // Tampilkan semua absensi
    public function index()
    {
        $absensis = Absensi::with(['siswa', 'absen'])->get();
        return response()->json([
            'success' => true,
            'data' => $absensis
        ]);
    }

    // Tambah absensi baru
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'absen_id' => 'required|exists:absens,id',
            'status' => 'required|in:0,1',
        ]);

        $absensi = Absensi::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil ditambahkan',
            'data' => $absensi->load(['siswa', 'absen'])
        ], 201);
    }

    // Tampilkan satu absensi
    public function show($id)
    {
        $absensi = Absensi::with(['siswa', 'absen'])->find($id);

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $absensi
        ]);
    }

    // Update absensi
    public function update(Request $request, $id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'absen_id' => 'required|exists:absens,id',
            'status' => 'required|in:0,1',
        ]);

        $absensi->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil diupdate',
            'data' => $absensi->load(['siswa', 'absen'])
        ]);
    }

    // Hapus absensi
    public function destroy($id)
    {
        $absensi = Absensi::find($id);

        if (!$absensi) {
            return response()->json([
                'success' => false,
                'message' => 'Absensi tidak ditemukan'
            ], 404);
        }

        $absensi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil dihapus'
        ]);
    }
}
