<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Absen;
use App\Models\Absensi;
use App\Models\AbsenLogBook;
use App\Models\Guru;
use App\Models\LogbookMengajar;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // Tampilkan semua absensi
    public function index()
    {
        $absensis = Absensi::with(['siswa', 'absen'])->get();
        return response()->json([
            'success' => true,
            'data'    => $absensis
        ]);
    }

    /**
     * BULK STORE: Simpan sesi absen + semua kehadiran siswa dalam 1 request
     * Dipakai oleh Guru saat menekan tombol Simpan di form buat absen
     *
     * Request body:
     * {
     *   "tanggal": "2026-06-01",
     *   "jam_mulai": "08:00",
     *   "jam_selesai": "09:30",
     *   "tingkat": "XI",
     *   "pertemuan": "P-1",
     *   "materi": "...",
     *   "catatan_guru": "...",
     *   "mapel_id": 1,
     *   "guru_id": 2,
     *   "absensi": [
     *     { "siswa_id": 1, "status": "hadir", "keterangan": "" },
     *     { "siswa_id": 2, "status": "alpa", "keterangan": "" }
     *   ]
     * }
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'tanggal'          => 'required|date',
            'jam_mulai'        => 'required|date_format:H:i',
            'jam_selesai'      => 'required|date_format:H:i|after:jam_mulai',
            'tingkat'          => 'required|in:X,XI,XII',
            'pertemuan'        => 'required|string',
            'materi'           => 'nullable|string',
            'catatan_guru'     => 'nullable|string',
            'mapel_id'         => 'required|exists:mapels,id',
            'guru_id'          => 'required|exists:gurus,id',
            'absensi'          => 'required|array|min:1',
            'absensi.*.siswa_id' => 'required|exists:siswas,id',
            'absensi.*.status'   => 'required|in:hadir,izin,sakit,alpa',
            'absensi.*.keterangan' => 'nullable|string',
        ]);

        // 1. Buat sesi absen
        $absen = Absen::create([
            'tanggal'      => $request->tanggal,
            'jam_mulai'    => $request->jam_mulai,
            'jam_selesai'  => $request->jam_selesai,
            'tingkat'      => $request->tingkat,
            'pertemuan'    => $request->pertemuan,
            'materi'       => $request->materi,
            'catatan_guru' => $request->catatan_guru,
            'dibuka_pada'  => now(),
            'mapel_id'     => $request->mapel_id,
            'guru_id'      => $request->guru_id,
        ]);

        // 2. Simpan semua absensi siswa
        $absensiData = [];
        foreach ($request->absensi as $item) {
            $absensiData[] = Absensi::create([
                'absen_id'   => $absen->id,
                'siswa_id'   => $item['siswa_id'],
                'status'     => $item['status'],
                'keterangan' => $item['keterangan'] ?? null,
            ]);
        }

        // 3. Catat di log book
        $totalHadir = collect($request->absensi)->where('status', 'hadir')->count();
        $totalSiswa = count($request->absensi);

        AbsenLogBook::create([
            'absen_id'    => $absen->id,
            'user_id'     => $request->user()->id,
            'aksi'        => 'sesi_dibuat',
            'deskripsi'   => "Sesi absen dibuat. {$totalHadir} dari {$totalSiswa} siswa hadir.",
            'data_sesudah'=> [
                'absen'   => $absen->toArray(),
                'absensi' => $request->absensi,
            ],
            'ip_address'  => $request->ip(),
        ]);

        // 4. Auto-create LogBook Mengajar (status=draft)
        LogbookMengajar::create([
            'absen_id'           => $absen->id,
            'guru_id'            => $request->guru_id,
            'materi_pembelajaran'=> $request->materi,  // pre-fill dari absen
            'status'             => 'draft',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil disimpan',
            'data'    => [
                'absen'          => $absen->load(['mapel', 'guru']),
                'total_siswa'    => $totalSiswa,
                'total_hadir'    => $totalHadir,
            ]
        ], 201);
    }

    // Tambah absensi satu siswa
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'absen_id' => 'required|exists:absens,id',
            'status'   => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable|string',
        ]);

        $absensi = Absensi::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil ditambahkan',
            'data'    => $absensi->load(['siswa', 'absen'])
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
            'data'    => $absensi
        ]);
    }

    /**
     * Update status absensi satu siswa (Guru/Admin bisa edit)
     * Setiap perubahan dicatat di log book
     */
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
            'status'     => 'required|in:hadir,izin,sakit,alpa',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan data sebelum diubah untuk log
        $dataSebelum = [
            'status'     => $absensi->status,
            'keterangan' => $absensi->keterangan,
        ];

        $absensi->update($request->only(['status', 'keterangan']));

        // Catat perubahan di log book
        $siswa = $absensi->siswa;
        AbsenLogBook::create([
            'absen_id'    => $absensi->absen_id,
            'user_id'     => $request->user()->id,
            'aksi'        => 'absen_diubah',
            'deskripsi'   => "Status absen {$siswa->nama} diubah dari [{$dataSebelum['status']}] menjadi [{$request->status}]",
            'data_sebelum'=> $dataSebelum,
            'data_sesudah'=> [
                'status'     => $request->status,
                'keterangan' => $request->keterangan,
            ],
            'ip_address'  => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil diupdate',
            'data'    => $absensi->load(['siswa', 'absen'])
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

    /**
     * Detail lengkap satu sesi absen beserta daftar siswa dan log book
     * Digunakan oleh tombol "Detail" di tabel riwayat
     */
    public function getDetailSesi($absen_id)
    {
        $absen = Absen::with([
            'mapel',
            'guru',
            'absensis.siswa',
            'logBooks.user',
        ])->find($absen_id);

        if (!$absen) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi absen tidak ditemukan'
            ], 404);
        }

        // Hitung statistik kehadiran
        $stats = [
            'total_siswa' => $absen->absensis->count(),
            'hadir'  => $absen->absensis->where('status', 'hadir')->count(),
            'izin'   => $absen->absensis->where('status', 'izin')->count(),
            'sakit'  => $absen->absensis->where('status', 'sakit')->count(),
            'alpa'   => $absen->absensis->where('status', 'alpa')->count(),
        ];

        return response()->json([
            'success' => true,
            'data'    => [
                'absen'    => $absen,
                'statistik'=> $stats,
                'log_books'=> $absen->logBooks,
            ]
        ]);
    }

    /**
     * Riwayat absensi satu siswa (dipakai oleh Siswa dan Admin)
     * Grouped by mata pelajaran dengan persentase kehadiran
     */
    public function getAbsensiSiswa($siswa_id)
    {
        $absensis = Absensi::where('siswa_id', $siswa_id)
            ->with(['absen.mapel', 'absen.guru'])
            ->orderBy('created_at', 'desc')
            ->get();

        if ($absensis->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Belum ada riwayat absensi',
                'data'    => [],
                'stats'   => ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpa' => 0, 'total' => 0],
            ]);
        }

        // Group by mapel dan hitung persentase
        $grouped = $absensis->groupBy(function ($item) {
            return $item->absen->mapel_id ?? 'unknown';
        })->map(function ($items, $mapelId) {
            $mapel     = $items->first()->absen->mapel;
            $total     = $items->count();
            $hadir     = $items->where('status', 'hadir')->count();
            $izin      = $items->where('status', 'izin')->count();
            $sakit     = $items->where('status', 'sakit')->count();
            $alpa      = $items->where('status', 'alpa')->count();
            $persentase= $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

            return [
                'mapel'       => $mapel,
                'total'       => $total,
                'hadir'       => $hadir,
                'izin'        => $izin,
                'sakit'       => $sakit,
                'alpa'        => $alpa,
                'persentase'  => $persentase,
                'detail'      => $items->map(function ($a) {
                    return [
                        'absen_id'     => $a->absen_id,
                        'tanggal'      => $a->absen->tanggal,
                        'pertemuan'    => $a->absen->pertemuan,
                        'jam_mulai'    => $a->absen->jam_mulai,
                        'jam_selesai'  => $a->absen->jam_selesai,
                        'status'       => $a->status,
                        'keterangan'   => $a->keterangan,
                        'guru'         => $a->absen->guru,
                    ];
                })->values(),
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data'    => $grouped,
            'stats'   => [
                'hadir'  => $absensis->where('status', 'hadir')->count(),
                'izin'   => $absensis->where('status', 'izin')->count(),
                'sakit'  => $absensis->where('status', 'sakit')->count(),
                'alpa'   => $absensis->where('status', 'alpa')->count(),
                'total'  => $absensis->count(),
            ]
        ]);
    }
}
