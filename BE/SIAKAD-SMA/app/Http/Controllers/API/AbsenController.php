<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Absen;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    // Tampilkan semua absen
    public function index()
    {
        $absens = Absen::with(['mapel', 'guru'])->get();
        return response()->json([
            'success' => true,
            'data' => $absens
        ]);
    }

    // Tambah absen baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'pertemuan' => 'required|string',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        $absen = Absen::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Absen berhasil ditambahkan',
            'data' => $absen->load(['mapel', 'guru'])
        ], 201);
    }

    // Tampilkan satu absen
    public function show($id)
    {
        $absen = Absen::with(['mapel', 'guru'])->find($id);

        if (!$absen) {
            return response()->json([
                'success' => false,
                'message' => 'Absen tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $absen
        ]);
    }

    // Update absen
    public function update(Request $request, $id)
    {
        $absen = Absen::find($id);

        if (!$absen) {
            return response()->json([
                'success' => false,
                'message' => 'Absen tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'pertemuan' => 'required|string',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:gurus,id',
        ]);

        $absen->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Absen berhasil diupdate',
            'data' => $absen->load(['mapel', 'guru'])
        ]);
    }

    // Hapus absen
    public function destroy($id)
    {
        $absen = Absen::find($id);

        if (!$absen) {
            return response()->json([
                'success' => false,
                'message' => 'Absen tidak ditemukan'
            ], 404);
        }

        $absen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Absen berhasil dihapus'
        ]);
    }
}
