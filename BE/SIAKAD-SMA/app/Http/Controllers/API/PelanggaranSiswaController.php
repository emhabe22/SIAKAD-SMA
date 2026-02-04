<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PelanggaranSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PelanggaranSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PelanggaranSiswa::with(['siswa', 'point', 'bk']);

        // Filter by siswa
        if ($request->has('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }

        // Filter by tanggal
        if ($request->has('tanggal_dari') && $request->has('tanggal_sampai')) {
            $query->whereBetween('tanggal', [$request->tanggal_dari, $request->tanggal_sampai]);
        }

        $pelanggarans = $query->orderBy('tanggal', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $pelanggarans
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required|exists:siswas,id',
            'point_id' => 'required|exists:points,id',
            'bk_id' => 'required|exists:b_k_s,id',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $pelanggaran = PelanggaranSiswa::create($request->all());
        $pelanggaran->load(['siswa', 'point', 'bk']);

        return response()->json([
            'success' => true,
            'message' => 'Pelanggaran siswa berhasil dicatat',
            'data' => $pelanggaran
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pelanggaran = PelanggaranSiswa::with(['siswa', 'point', 'bk'])->find($id);

        if (!$pelanggaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggaran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pelanggaran
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pelanggaran = PelanggaranSiswa::find($id);

        if (!$pelanggaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggaran tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'siswa_id' => 'sometimes|required|exists:siswas,id',
            'point_id' => 'sometimes|required|exists:points,id',
            'bk_id' => 'sometimes|required|exists:b_k_s,id',
            'tanggal' => 'sometimes|required|date',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $pelanggaran->update($request->all());
        $pelanggaran->load(['siswa', 'point', 'bk']);

        return response()->json([
            'success' => true,
            'message' => 'Data pelanggaran berhasil diupdate',
            'data' => $pelanggaran
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pelanggaran = PelanggaranSiswa::find($id);

        if (!$pelanggaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggaran tidak ditemukan'
            ], 404);
        }

        $pelanggaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pelanggaran berhasil dihapus'
        ]);
    }

    /**
     * Get total point pelanggaran siswa
     */
    public function getTotalPointSiswa($siswa_id)
    {
        $totalPoint = PelanggaranSiswa::where('siswa_id', $siswa_id)
            ->join('points', 'pelanggaran_siswas.point_id', '=', 'points.id')
            ->sum('points.nilai');

        $riwayatPelanggaran = PelanggaranSiswa::with(['point', 'bk'])
            ->where('siswa_id', $siswa_id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_point' => $totalPoint,
                'riwayat' => $riwayatPelanggaran
            ]
        ]);
    }

    /**
     * Get siswa bermasalah (dengan point tinggi)
     */
    public function getSiswaBermasalah()
    {
        $siswaBermasalah = DB::table('siswas')
            ->join('pelanggaran_siswas', 'siswas.id', '=', 'pelanggaran_siswas.siswa_id')
            ->join('points', 'pelanggaran_siswas.point_id', '=', 'points.id')
            ->join('kelas', 'siswas.kelas_id', '=', 'kelas.id')
            ->select(
                'siswas.id',
                'siswas.nama',
                'siswas.nisn',
                'kelas.nama_kelas',
                DB::raw('SUM(points.nilai) as total_point'),
                DB::raw('COUNT(pelanggaran_siswas.id) as jumlah_pelanggaran')
            )
            ->groupBy('siswas.id', 'siswas.nama', 'siswas.nisn', 'kelas.nama_kelas')
            ->orderBy('total_point', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $siswaBermasalah
        ]);
    }
}
