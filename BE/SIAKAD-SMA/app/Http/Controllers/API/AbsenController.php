<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Absen;
use App\Models\AbsenLogBook;
use App\Models\Guru;
use App\Models\LogbookMengajar;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    // Tampilkan semua absen (admin: semua, guru: miliknya sendiri)
    public function index(Request $request)
    {
        $query = Absen::with(['mapel', 'guru']);

        // Filter by guru_id (admin bisa filter, guru otomatis hanya miliknya)
        if ($request->has('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        // Filter by tanggal
        if ($request->has('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        // Filter by tingkat
        if ($request->has('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        $absens = $query->orderBy('tanggal', 'desc')->orderBy('jam_mulai', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $absens
        ]);
    }

    // Tambah sesi absen baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'tingkat'     => 'required|in:X,XI,XII',
            'pertemuan'   => 'required|string',
            'materi'      => 'nullable|string',
            'catatan_guru'=> 'nullable|string',
            'mapel_id'    => 'required|exists:mapels,id',
            'guru_id'     => 'required|exists:gurus,id',
        ]);

        $absen = Absen::create(array_merge($request->all(), [
            'dibuka_pada' => now(),
        ]));

        // Catat di log book
        AbsenLogBook::create([
            'absen_id'    => $absen->id,
            'user_id'     => $request->user()->id,
            'aksi'        => 'sesi_dibuat',
            'deskripsi'   => 'Sesi absen dibuat untuk ' . $request->tingkat . ' - Pertemuan ' . $request->pertemuan,
            'data_sesudah'=> $absen->toArray(),
            'ip_address'  => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sesi absen berhasil dibuat',
            'data'    => $absen->load(['mapel', 'guru'])
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
            'data'    => $absen
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
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'tingkat'     => 'required|in:X,XI,XII',
            'pertemuan'   => 'required|string',
            'materi'      => 'nullable|string',
            'catatan_guru'=> 'nullable|string',
            'mapel_id'    => 'required|exists:mapels,id',
            'guru_id'     => 'required|exists:gurus,id',
        ]);

        $absen->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Absen berhasil diupdate',
            'data'    => $absen->load(['mapel', 'guru'])
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

    /**
     * Ambil mapel milik guru yang sedang login
     * Digunakan untuk prefill form buat absen
     */
    public function getMapelGuru(Request $request)
    {
        $user   = $request->user();
        $guru   = Guru::where('user_id', $user->id)->with('mapels')->first();

        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'guru'   => $guru,
                'mapels' => $guru->mapels
            ]
        ]);
    }

    /**
     * Ambil daftar siswa berdasarkan tingkat
     * Digunakan saat guru memilih tingkat untuk mengisi checklist absensi
     */
    public function getSiswaByTingkat($tingkat)
    {
        $siswas = \App\Models\Siswa::where('tingkat', $tingkat)
            ->select('id', 'nama', 'nisn', 'jenis_kelamin', 'foto')
            ->orderBy('nama')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $siswas
        ]);
    }

    /**
     * Ambil semua sesi absen milik guru yang sedang login
     */
    public function getAbsenGuru(Request $request)
    {
        $user = $request->user();
        $guru = Guru::where('user_id', $user->id)->first();

        if (!$guru) {
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        $absens = Absen::with(['mapel', 'absensis'])
            ->where('guru_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->get()
            ->map(function ($absen) {
                $absen->total_hadir = $absen->absensis->where('status', 'hadir')->count();
                $absen->total_alpa  = $absen->absensis->where('status', 'alpa')->count();
                $absen->total_izin  = $absen->absensis->where('status', 'izin')->count();
                $absen->total_sakit = $absen->absensis->where('status', 'sakit')->count();
                $absen->total_siswa = $absen->absensis->count();
                return $absen;
            });

        return response()->json([
            'success' => true,
            'data'    => $absens
        ]);
    }
}
