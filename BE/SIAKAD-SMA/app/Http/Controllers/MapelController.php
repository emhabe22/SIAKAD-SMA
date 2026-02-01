<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    // Tampilkan semua mapel
    public function index()
    {
        $mapels = Mapel::with('kelas')->get();
        return response()->json([
            'success' => true,
            'data' => $mapels
        ]);
    }

    // Tambah mapel baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $mapel = Mapel::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil ditambahkan',
            'data' => $mapel->load('kelas')
        ], 201);
    }

    // Tampilkan satu mapel
    public function show($id)
    {
        $mapel = Mapel::with('kelas')->find($id);

        if (!$mapel) {
            return response()->json([
                'success' => false,
                'message' => 'Mapel tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $mapel
        ]);
    }

    // Update mapel
    public function update(Request $request, $id)
    {
        $mapel = Mapel::find($id);

        if (!$mapel) {
            return response()->json([
                'success' => false,
                'message' => 'Mapel tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama_mapel' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $mapel->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil diupdate',
            'data' => $mapel->load('kelas')
        ]);
    }

    // Hapus mapel
    public function destroy($id)
    {
        $mapel = Mapel::find($id);

        if (!$mapel) {
            return response()->json([
                'success' => false,
                'message' => 'Mapel tidak ditemukan'
            ], 404);
        }

        $mapel->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil dihapus'
        ]);
    }
}
