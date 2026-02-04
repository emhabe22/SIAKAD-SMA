<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     * Filter by kelas_id, hari, guru_id
     */
    public function index(Request $request)
    {
        $query = JadwalPelajaran::with(['kelas', 'mapel', 'guru']);

        // Filter by kelas
        if ($request->has('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter by hari
        if ($request->has('hari')) {
            $query->where('hari', $request->hari);
        }

        // Filter by guru
        if ($request->has('guru_id')) {
            $query->where('guru_id', $request->guru_id);
        }

        $jadwals = $query->orderBy('hari')->orderBy('jam_mulai')->get();

        return response()->json([
            'success' => true,
            'data' => $jadwals
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:gurus,id',
            'ruangan' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $jadwal = JadwalPelajaran::create($request->all());
        $jadwal->load(['kelas', 'mapel', 'guru']);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal pelajaran berhasil ditambahkan',
            'data' => $jadwal
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwal = JadwalPelajaran::with(['kelas', 'mapel', 'guru'])->find($id);

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal pelajaran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $jadwal
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jadwal = JadwalPelajaran::find($id);

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal pelajaran tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'hari' => 'sometimes|required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'sometimes|required|date_format:H:i',
            'jam_selesai' => 'sometimes|required|date_format:H:i|after:jam_mulai',
            'kelas_id' => 'sometimes|required|exists:kelas,id',
            'mapel_id' => 'sometimes|required|exists:mapels,id',
            'guru_id' => 'sometimes|required|exists:gurus,id',
            'ruangan' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $jadwal->update($request->all());
        $jadwal->load(['kelas', 'mapel', 'guru']);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal pelajaran berhasil diupdate',
            'data' => $jadwal
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jadwal = JadwalPelajaran::find($id);

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal pelajaran tidak ditemukan'
            ], 404);
        }

        $jadwal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal pelajaran berhasil dihapus'
        ]);
    }

    /**
     * Get jadwal by kelas untuk siswa
     */
    public function getJadwalByKelas($kelas_id)
    {
        $jadwals = JadwalPelajaran::with(['mapel', 'guru'])
            ->where('kelas_id', $kelas_id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        // Group by hari
        $jadwalGrouped = $jadwals->groupBy('hari');

        return response()->json([
            'success' => true,
            'data' => $jadwalGrouped
        ]);
    }

    /**
     * Get jadwal mengajar untuk guru
     */
    public function getJadwalGuru($guru_id)
    {
        $jadwals = JadwalPelajaran::with(['kelas', 'mapel'])
            ->where('guru_id', $guru_id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        // Group by hari
        $jadwalGrouped = $jadwals->groupBy('hari');

        return response()->json([
            'success' => true,
            'data' => $jadwalGrouped
        ]);
    }
}
