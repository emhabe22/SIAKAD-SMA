<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Bimbingan;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    // Tampilkan semua bimbingan
    public function index()
    {
        $bimbingans = Bimbingan::with(['penjadwalan', 'point'])->get();
        return response()->json([
            'success' => true,
            'data' => $bimbingans
        ]);
    }

    // Tambah bimbingan baru
    public function store(Request $request)
    {
        $request->validate([
            'catatan' => 'required|string',
            'ringkasan' => 'required|string',
            'penjadwalan_id' => 'required|exists:penjadwalans,id',
            'point_id' => 'required|exists:points,id',
        ]);

        $bimbingan = Bimbingan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Bimbingan berhasil ditambahkan',
            'data' => $bimbingan->load(['penjadwalan', 'point'])
        ], 201);
    }

    // Tampilkan satu bimbingan
    public function show($id)
    {
        $bimbingan = Bimbingan::with(['penjadwalan', 'point'])->find($id);

        if (!$bimbingan) {
            return response()->json([
                'success' => false,
                'message' => 'Bimbingan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $bimbingan
        ]);
    }

    // Update bimbingan
    public function update(Request $request, $id)
    {
        $bimbingan = Bimbingan::find($id);

        if (!$bimbingan) {
            return response()->json([
                'success' => false,
                'message' => 'Bimbingan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'catatan' => 'required|string',
            'ringkasan' => 'required|string',
            'penjadwalan_id' => 'required|exists:penjadwalans,id',
            'point_id' => 'required|exists:points,id',
        ]);

        $bimbingan->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Bimbingan berhasil diupdate',
            'data' => $bimbingan->load(['penjadwalan', 'point'])
        ]);
    }

    // Hapus bimbingan
    public function destroy($id)
    {
        $bimbingan = Bimbingan::find($id);

        if (!$bimbingan) {
            return response()->json([
                'success' => false,
                'message' => 'Bimbingan tidak ditemukan'
            ], 404);
        }

        $bimbingan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bimbingan berhasil dihapus'
        ]);
    }
}
