<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    // Tampilkan semua kelas
    public function index()
    {
        $kelas = Kelas::all();
        return response()->json([
            'success' => true,
            'data' => $kelas
        ]);
    }

    // Tambah kelas baru
    public function store(Request $request)
    {
        $kelas = Kelas::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil ditambahkan',
            'data' => $kelas
        ], 201);
    }

    // Tampilkan satu kelas
    public function show($id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $kelas
        ]);
    }

    // Update kelas
    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        }

        $kelas->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil diupdate',
            'data' => $kelas
        ]);
    }

    // Hapus kelas
    public function destroy($id)
    {
        $kelas = Kelas::find($id);

        if (!$kelas) {
            return response()->json([
                'success' => false,
                'message' => 'Kelas tidak ditemukan'
            ], 404);
        }

        $kelas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil dihapus'
        ]);
    }
}
