<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\LogbookMengajar;
use Illuminate\Http\Request;

class LogbookMengajarController extends Controller
{
    /**
     * GET /api/guru/logbook
     * Daftar semua logbook milik guru yang sedang login
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return response()->json(['success' => false, 'message' => 'Data guru tidak ditemukan'], 404);
        }

        $logbooks = LogbookMengajar::with(['absen.mapel', 'absen.absensis'])
            ->where('guru_id', $guru->id)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($lb) {
                $lb->total_hadir   = $lb->absen?->absensis?->where('status', 'hadir')->count() ?? 0;
                $lb->total_siswa   = $lb->absen?->absensis?->count() ?? 0;
                $lb->is_lengkap    = $lb->isLengkap();
                return $lb;
            });

        // Stat: entri bulan ini
        $now = now();
        $entriBulanIni = $logbooks->filter(function ($lb) use ($now) {
            return $lb->created_at && $lb->created_at->month === $now->month
                && $lb->created_at->year === $now->year;
        })->count();

        $perluDiserahkan = $logbooks->where('status', 'draft')->count();

        return response()->json([
            'success' => true,
            'data'    => $logbooks,
            'stats'   => [
                'entri_bulan_ini'  => $entriBulanIni,
                'perlu_diserahkan' => $perluDiserahkan,
            ],
        ]);
    }

    /**
     * GET /api/guru/logbook/{id}
     * Detail satu logbook
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $guru = Guru::where('user_id', $user->id)->first();

        $logbook = LogbookMengajar::with(['absen.mapel', 'absen.guru', 'absen.absensis.siswa'])
            ->where('id', $id)
            ->where('guru_id', $guru?->id)
            ->first();

        if (!$logbook) {
            return response()->json(['success' => false, 'message' => 'Logbook tidak ditemukan'], 404);
        }

        $logbook->total_hadir = $logbook->absen?->absensis?->where('status', 'hadir')->count() ?? 0;
        $logbook->total_siswa = $logbook->absen?->absensis?->count() ?? 0;

        return response()->json(['success' => true, 'data' => $logbook]);
    }

    /**
     * PUT /api/guru/logbook/{id}
     * Update isi logbook (hanya jika status masih draft)
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $guru = Guru::where('user_id', $user->id)->first();

        $logbook = LogbookMengajar::where('id', $id)
            ->where('guru_id', $guru?->id)
            ->first();

        if (!$logbook) {
            return response()->json(['success' => false, 'message' => 'Logbook tidak ditemukan'], 404);
        }

        if ($logbook->status === 'diserahkan') {
            return response()->json([
                'success' => false,
                'message' => 'Logbook yang sudah diserahkan tidak dapat diubah',
            ], 403);
        }

        $request->validate([
            'materi_pembelajaran' => 'nullable|string',
            'metode_pembelajaran'  => 'nullable|string',
            'tugas_evaluasi'       => 'nullable|string',
        ]);

        $logbook->update($request->only([
            'materi_pembelajaran',
            'metode_pembelajaran',
            'tugas_evaluasi',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Logbook berhasil disimpan',
            'data'    => $logbook,
        ]);
    }

    /**
     * POST /api/guru/logbook/{id}/serahkan
     * Serahkan logbook ke admin (FINAL - tidak bisa dibatalkan)
     */
    public function serahkan(Request $request, $id)
    {
        $user = $request->user();
        $guru = Guru::where('user_id', $user->id)->first();

        $logbook = LogbookMengajar::where('id', $id)
            ->where('guru_id', $guru?->id)
            ->first();

        if (!$logbook) {
            return response()->json(['success' => false, 'message' => 'Logbook tidak ditemukan'], 404);
        }

        if ($logbook->status === 'diserahkan') {
            return response()->json([
                'success' => false,
                'message' => 'Logbook sudah diserahkan sebelumnya',
            ], 422);
        }

        if (!$logbook->isLengkap()) {
            return response()->json([
                'success' => false,
                'message' => 'Logbook belum lengkap. Harap isi Materi, Metode Pembelajaran, dan Tugas & Evaluasi terlebih dahulu.',
            ], 422);
        }

        $logbook->update([
            'status'         => 'diserahkan',
            'diserahkan_at'  => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Logbook berhasil diserahkan ke admin',
            'data'    => $logbook,
        ]);
    }

    // ============================================================
    // ADMIN ROUTES
    // ============================================================

    /**
     * GET /api/admin/logbook-guru
     * Daftar semua guru beserta ringkasan logbook mereka
     */
    public function indexAdmin(Request $request)
    {
        $gurus = Guru::with(['mapels'])->get()->map(function ($guru) {
            $logbooks       = LogbookMengajar::where('guru_id', $guru->id)->get();
            $guru->total_logbook       = $logbooks->count();
            $guru->total_diserahkan    = $logbooks->where('status', 'diserahkan')->count();
            $guru->total_draft         = $logbooks->where('status', 'draft')->count();
            return $guru;
        });

        return response()->json(['success' => true, 'data' => $gurus]);
    }

    /**
     * GET /api/admin/logbook-guru/{guru_id}
     * Semua logbook dari satu guru (untuk admin)
     */
    public function showByGuru(Request $request, $guru_id)
    {
        $guru = Guru::find($guru_id);
        if (!$guru) {
            return response()->json(['success' => false, 'message' => 'Guru tidak ditemukan'], 404);
        }

        $logbooks = LogbookMengajar::with(['absen.mapel', 'absen.absensis'])
            ->where('guru_id', $guru_id)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($lb) {
                $lb->total_hadir = $lb->absen?->absensis?->where('status', 'hadir')->count() ?? 0;
                $lb->total_siswa = $lb->absen?->absensis?->count() ?? 0;
                $lb->is_lengkap  = $lb->isLengkap();
                return $lb;
            });

        return response()->json([
            'success' => true,
            'guru'    => $guru,
            'data'    => $logbooks,
        ]);
    }
}
