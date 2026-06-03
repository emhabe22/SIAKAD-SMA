<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\JadwalSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     * Filter by tingkat, hari, guru_id
     */
    public function index(Request $request)
    {
        $query = JadwalPelajaran::with(['mapel', 'guru', 'slot']);

        // Filter by tingkat
        if ($request->has('tingkat')) {
            $query->where('tingkat', $request->tingkat);
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
            'slot_id' => 'nullable|exists:jadwal_slots,id',
            'jam_mulai' => 'required_without:slot_id|date_format:H:i',
            'jam_selesai' => 'required_without:slot_id|date_format:H:i|after:jam_mulai',
            'tingkat' => 'required|in:X,XI,XII',
            'tipe' => 'nullable|in:mapel,kegiatan',
            'mapel_id' => 'required_unless:tipe,kegiatan|nullable|exists:mapels,id',
            'guru_id' => 'required_unless:tipe,kegiatan|nullable|exists:gurus,id',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['tipe'] = $data['tipe'] ?? 'mapel';

        if (!empty($data['slot_id'])) {
            $slot = JadwalSlot::find($data['slot_id']);
            if ($slot) {
                $data['jam_mulai'] = $slot->jam_mulai;
                $data['jam_selesai'] = $slot->jam_selesai;
                if (!array_key_exists('tipe', $data)) {
                    $data['tipe'] = $slot->tipe;
                }
            }
        }

        if (($data['tipe'] ?? 'mapel') === 'kegiatan') {
            $data['mapel_id'] = null;
            $data['guru_id'] = null;
        }

        $jadwal = JadwalPelajaran::create($data);
        $jadwal->load(['mapel', 'guru', 'slot']);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal pelajaran berhasil ditambahkan',
            'data' => $jadwal
        ], 201);
    }

    /**
     * Store multiple resources in storage (Bulk).
     */
    public function bulkStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'tingkat' => 'required|in:X,XI,XII',
            'jadwals' => 'required|array',
            'jadwals.*.id' => 'nullable|exists:jadwal_pelajarans,id',
            'jadwals.*.slot_id' => 'required|exists:jadwal_slots,id',
            'jadwals.*.tipe' => 'nullable|in:mapel,kegiatan',
            'jadwals.*.mapel_id' => 'nullable|exists:mapels,id',
            'jadwals.*.guru_id' => 'nullable|exists:gurus,id',
            'jadwals.*.keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $hari = $request->hari;
        $tingkat = $request->tingkat;
        $jadwalsData = $request->jadwals;

        \DB::beginTransaction();
        try {
            foreach ($jadwalsData as $item) {
                $tipe = $item['tipe'] ?? 'mapel';
                $isKegiatan = $tipe === 'kegiatan';

                // Jika kegiatan, tidak perlu mapel dan guru
                $mapelId = $isKegiatan ? null : ($item['mapel_id'] ?? null);
                $guruId = $isKegiatan ? null : ($item['guru_id'] ?? null);

                // Jika mapel (bukan kegiatan) dan tidak ada isinya (dikosongkan oleh user)
                if (!$isKegiatan && !$mapelId && !$guruId) {
                    // Jika ada ID, berarti dihapus
                    if (!empty($item['id'])) {
                        JadwalPelajaran::where('id', $item['id'])->delete();
                    }
                    continue; // Skip insert/update
                }

                $slot = JadwalSlot::find($item['slot_id']);
                if (!$slot) continue;

                $data = [
                    'hari' => $hari,
                    'tingkat' => $tingkat,
                    'slot_id' => $slot->id,
                    'jam_mulai' => $slot->jam_mulai,
                    'jam_selesai' => $slot->jam_selesai,
                    'tipe' => $tipe,
                    'mapel_id' => $mapelId,
                    'guru_id' => $guruId,
                    'keterangan' => $item['keterangan'] ?? null,
                ];

                if (!empty($item['id'])) {
                    // Update
                    JadwalPelajaran::where('id', $item['id'])->update($data);
                } else {
                    // Create
                    JadwalPelajaran::create($data);
                }
            }

            \DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Semua jadwal berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan jadwal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwal = JadwalPelajaran::with(['mapel', 'guru', 'slot'])->find($id);

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
            'slot_id' => 'sometimes|required|exists:jadwal_slots,id',
            'jam_mulai' => 'sometimes|required_without:slot_id|date_format:H:i',
            'jam_selesai' => 'sometimes|required_without:slot_id|date_format:H:i|after:jam_mulai',
            'tingkat' => 'sometimes|required|in:X,XI,XII',
            'tipe' => 'sometimes|required|in:mapel,kegiatan',
            'mapel_id' => 'sometimes|required_unless:tipe,kegiatan|nullable|exists:mapels,id',
            'guru_id' => 'sometimes|required_unless:tipe,kegiatan|nullable|exists:gurus,id',
            'keterangan' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if (!empty($data['slot_id'])) {
            $slot = JadwalSlot::find($data['slot_id']);
            if ($slot) {
                $data['jam_mulai'] = $slot->jam_mulai;
                $data['jam_selesai'] = $slot->jam_selesai;
                if (!array_key_exists('tipe', $data)) {
                    $data['tipe'] = $slot->tipe;
                }
            }
        }

        $tipe = $data['tipe'] ?? $jadwal->tipe ?? 'mapel';
        if ($tipe === 'kegiatan') {
            $data['mapel_id'] = null;
            $data['guru_id'] = null;
        }

        $jadwal->update($data);
        $jadwal->load(['mapel', 'guru', 'slot']);

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
     * Get jadwal by tingkat untuk siswa
     */
    public function getJadwalByTingkat($tingkat)
    {
        $jadwals = JadwalPelajaran::with(['mapel', 'guru', 'slot'])
            ->where('tingkat', $tingkat)
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
        $jadwals = JadwalPelajaran::with(['mapel', 'slot'])
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
