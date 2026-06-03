<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Penjadwalan;
use Illuminate\Http\Request;

class PenjadwalanController extends Controller
{
    // Tampilkan semua penjadwalan
    public function index()
    {
        $penjadwalans = Penjadwalan::with(['siswa', 'bk'])->get();
        return response()->json([
            'success' => true,
            'data' => $penjadwalans
        ]);
    }

    // Tambah penjadwalan baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'siswa_id' => 'required|exists:siswas,id',
            'bk_id' => 'required|exists:b_k_s,id',
            'status' => 'nullable|in:0,1',
            'keterangan' => 'nullable|string',
        ]);

        $penjadwalan = Penjadwalan::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Penjadwalan berhasil ditambahkan',
            'data' => $penjadwalan->load(['siswa', 'bk'])
        ], 201);
    }

    // Tampilkan satu penjadwalan
    public function show($id)
    {
        $penjadwalan = Penjadwalan::with(['siswa', 'bk'])->find($id);

        if (!$penjadwalan) {
            return response()->json([
                'success' => false,
                'message' => 'Penjadwalan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $penjadwalan
        ]);
    }

    // Update penjadwalan
    public function update(Request $request, $id)
    {
        $penjadwalan = Penjadwalan::find($id);

        if (!$penjadwalan) {
            return response()->json([
                'success' => false,
                'message' => 'Penjadwalan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'siswa_id' => 'required|exists:siswas,id',
            'bk_id' => 'required|exists:b_k_s,id',
            'status' => 'nullable|in:0,1',
            'keterangan' => 'nullable|string',
        ]);

        $penjadwalan->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Penjadwalan berhasil diupdate',
            'data' => $penjadwalan->load(['siswa', 'bk'])
        ]);
    }

    // Hapus penjadwalan
    public function destroy($id)
    {
        $penjadwalan = Penjadwalan::find($id);

        if (!$penjadwalan) {
            return response()->json([
                'success' => false,
                'message' => 'Penjadwalan tidak ditemukan'
            ], 404);
        }

        $penjadwalan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Penjadwalan berhasil dihapus'
        ]);
    }

    // Get penjadwalan by siswa_id
    public function getPenjadwalanSiswa($siswa_id)
    {
        $penjadwalans = Penjadwalan::with(['siswa', 'bk'])
            ->where('siswa_id', $siswa_id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $penjadwalans
        ]);
    }

    // Approve/konfirmasi penjadwalan
    public function approve($id)
    {
        $penjadwalan = Penjadwalan::find($id);

        if (!$penjadwalan) {
            return response()->json([
                'success' => false,
                'message' => 'Penjadwalan tidak ditemukan'
            ], 404);
        }

        $penjadwalan->update(['status' => '1']);

        return response()->json([
            'success' => true,
            'message' => 'Penjadwalan berhasil dikonfirmasi',
            'data' => $penjadwalan->load(['siswa', 'bk'])
        ]);
    }

    // Reject/tolak penjadwalan
    public function reject($id)
    {
        $penjadwalan = Penjadwalan::find($id);

        if (!$penjadwalan) {
            return response()->json([
                'success' => false,
                'message' => 'Penjadwalan tidak ditemukan'
            ], 404);
        }

        $penjadwalan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Penjadwalan berhasil ditolak dan dihapus'
        ]);
    }
}
