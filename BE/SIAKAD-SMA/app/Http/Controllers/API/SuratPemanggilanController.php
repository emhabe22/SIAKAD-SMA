<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SuratPemanggilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SuratPemanggilanController extends Controller
{
    public function index(Request $request)
    {
        $bk = $request->user()->bk;
        if (!$bk) {
            return response()->json([
                'success' => false,
                'message' => 'BK tidak ditemukan untuk user saat ini'
            ], 403);
        }

        $surat = SuratPemanggilan::with(['siswa', 'bk'])
            ->where('bk_id', $bk->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $surat
        ]);
    }

    public function store(Request $request)
    {
        $bk = $request->user()->bk;
        if (!$bk) {
            return response()->json([
                'success' => false,
                'message' => 'BK tidak ditemukan untuk user saat ini'
            ], 403);
        }

        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nomor_surat' => 'nullable|string|max:255',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_surat' => 'required|date',
            'tanggal_panggilan' => 'required|date',
            'waktu_panggilan' => 'required|string|max:50',
            'status' => 'nullable|in:draft,sent',
        ]);

        $suratPemanggilan = SuratPemanggilan::create(array_merge($validated, [
            'bk_id' => $bk->id,
            'status' => $validated['status'] ?? 'draft'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Surat pemanggilan berhasil dibuat',
            'data' => $suratPemanggilan->load(['siswa', 'bk'])
        ], 201);
    }

    public function show($id)
    {
        $suratPemanggilan = SuratPemanggilan::with(['siswa', 'bk'])->find($id);
        if ($suratPemanggilan && Auth::user()->bk && $suratPemanggilan->bk_id !== Auth::user()->bk->id) {
            $suratPemanggilan = null;
        }

        if (!$suratPemanggilan) {
            return response()->json([
                'success' => false,
                'message' => 'Surat pemanggilan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $suratPemanggilan
        ]);
    }

    public function update(Request $request, $id)
    {
        $suratPemanggilan = SuratPemanggilan::find($id);
        if ($suratPemanggilan && Auth::user()->bk && $suratPemanggilan->bk_id !== Auth::user()->bk->id) {
            $suratPemanggilan = null;
        }

        if (!$suratPemanggilan) {
            return response()->json([
                'success' => false,
                'message' => 'Surat pemanggilan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nomor_surat' => 'nullable|string|max:255',
            'perihal' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tanggal_surat' => 'required|date',
            'tanggal_panggilan' => 'required|date',
            'waktu_panggilan' => 'required|string|max:50',
            'status' => 'nullable|in:draft,sent',
        ]);

        $suratPemanggilan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Surat pemanggilan berhasil diperbarui',
            'data' => $suratPemanggilan->load(['siswa', 'bk'])
        ]);
    }

    public function destroy($id)
    {
        $suratPemanggilan = SuratPemanggilan::find($id);
        if ($suratPemanggilan && Auth::user()->bk && $suratPemanggilan->bk_id !== Auth::user()->bk->id) {
            $suratPemanggilan = null;
        }

        if (!$suratPemanggilan) {
            return response()->json([
                'success' => false,
                'message' => 'Surat pemanggilan tidak ditemukan'
            ], 404);
        }

        $suratPemanggilan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Surat pemanggilan berhasil dihapus'
        ]);
    }

    public function send($id)
    {
        $suratPemanggilan = SuratPemanggilan::find($id);
        if ($suratPemanggilan && Auth::user()->bk && $suratPemanggilan->bk_id !== Auth::user()->bk->id) {
            $suratPemanggilan = null;
        }

        if (!$suratPemanggilan) {
            return response()->json([
                'success' => false,
                'message' => 'Surat pemanggilan tidak ditemukan'
            ], 404);
        }

        $suratPemanggilan->update(['status' => 'sent']);

        return response()->json([
            'success' => true,
            'message' => 'Surat pemanggilan berhasil dikirim',
            'data' => $suratPemanggilan->load(['siswa', 'bk'])
        ]);
    }

    public function getSuratSiswa($siswa_id)
    {
        $suratData = SuratPemanggilan::with(['bk'])
            ->where('siswa_id', $siswa_id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $suratData
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $surat = SuratPemanggilan::find($id);
        if (!$surat) {
            return response()->json([
                'success' => false,
                'message' => 'Surat tidak ditemukan'
            ], 404);
        }

        // Ensure the authenticated user is the student owner
        $siswa = $request->user()->siswa ?? null;
        if ($siswa && $surat->siswa_id !== $siswa->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berwenang mengakses surat ini'
            ], 403);
        }

        $surat->read_at = Carbon::now();
        $surat->save();

        return response()->json([
            'success' => true,
            'message' => 'Surat ditandai sudah dibaca',
            'data' => $surat->load(['bk'])
        ]);
    }
}
