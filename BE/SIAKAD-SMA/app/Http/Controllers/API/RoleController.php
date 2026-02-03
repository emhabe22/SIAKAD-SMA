<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Tampilkan semua role
    public function index()
    {
        $roles = Role::all();
        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }

    // Tambah role baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role = Role::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil ditambahkan',
            'data' => $role
        ], 201);
    }

    // Tampilkan satu role
    public function show($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $role
        ]);
    }

    // Update role
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil diupdate',
            'data' => $role
        ]);
    }

    // Hapus role
    public function destroy($id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role tidak ditemukan'
            ], 404);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role berhasil dihapus'
        ]);
    }
}
