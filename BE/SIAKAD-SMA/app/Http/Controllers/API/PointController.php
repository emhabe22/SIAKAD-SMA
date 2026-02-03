<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    // Tampilkan semua point
    public function index()
    {
        $points = Point::all();
        return response()->json([
            'success' => true,
            'data' => $points
        ]);
    }

    // Tambah point baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nilai' => 'required|integer',
        ]);

        $point = Point::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Point berhasil ditambahkan',
            'data' => $point
        ], 201);
    }

    // Tampilkan satu point
    public function show($id)
    {
        $point = Point::find($id);

        if (!$point) {
            return response()->json([
                'success' => false,
                'message' => 'Point tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $point
        ]);
    }

    // Update point
    public function update(Request $request, $id)
    {
        $point = Point::find($id);

        if (!$point) {
            return response()->json([
                'success' => false,
                'message' => 'Point tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama' => 'required|string',
            'nilai' => 'required|integer',
        ]);

        $point->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Point berhasil diupdate',
            'data' => $point
        ]);
    }

    // Hapus point
    public function destroy($id)
    {
        $point = Point::find($id);

        if (!$point) {
            return response()->json([
                'success' => false,
                'message' => 'Point tidak ditemukan'
            ], 404);
        }

        $point->delete();

        return response()->json([
            'success' => true,
            'message' => 'Point berhasil dihapus'
        ]);
    }
}
