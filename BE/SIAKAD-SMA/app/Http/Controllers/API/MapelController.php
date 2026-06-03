<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    // Tampilkan semua mapel
    public function index()
    {
        $mapels = Mapel::with('gurus')->get();
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
            'kode_mapel' => 'required|string|unique:mapels',
            'tingkat' => 'required|in:X,XI,XII'
        ]);

        $mapel = Mapel::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil ditambahkan',
            'data' => $mapel->load('gurus')
        ], 201);
    }

    // Tampilkan satu mapel
    public function show($id)
    {
        $mapel = Mapel::with('gurus')->find($id);

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
            'nama_mapel' => 'sometimes|required|string',
            'kode_mapel' => 'sometimes|required|string|unique:mapels,kode_mapel,' . $id,
            'tingkat' => 'sometimes|required|in:X,XI,XII'
        ]);

        $mapel->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Mapel berhasil diupdate',
            'data' => $mapel->load('gurus')
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
