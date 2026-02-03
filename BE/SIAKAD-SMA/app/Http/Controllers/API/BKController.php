<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\BK;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BKController extends Controller
{
    // Tampilkan semua BK
    public function index()
    {
        $bks = BK::with('user')->get();
        return response()->json([
            'success' => true,
            'data' => $bks
        ]);
    }

    // Tambah BK baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nip' => 'required|unique:b_k_s',
            'alamat' => 'required|string',
            'no_telp' => 'required|integer',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        // Buat user dulu
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'role_id' => 1, // role BK
        ]);

        // Buat BK
        $bk = BK::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'BK berhasil ditambahkan',
            'data' => $bk->load('user')
        ], 201);
    }

    // Tampilkan satu BK
    public function show($id)
    {
        $bk = BK::with('user')->find($id);

        if (!$bk) {
            return response()->json([
                'success' => false,
                'message' => 'BK tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $bk
        ]);
    }

    // Update BK
    public function update(Request $request, $id)
    {
        $bk = BK::find($id);

        if (!$bk) {
            return response()->json([
                'success' => false,
                'message' => 'BK tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama' => 'required|string',
            'nip' => 'required|unique:b_k_s,nip,' . $id,
            'alamat' => 'required|string',
            'no_telp' => 'required|integer',
        ]);

        $bk->update($request->only(['nama', 'nip', 'alamat', 'no_telp']));

        // Update user nip
        $bk->user->update(['nip' => $request->nip]);

        // Update password jika ada
        if ($request->password) {
            $bk->user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'BK berhasil diupdate',
            'data' => $bk->load('user')
        ]);
    }

    // Hapus BK
    public function destroy($id)
    {
        $bk = BK::find($id);

        if (!$bk) {
            return response()->json([
                'success' => false,
                'message' => 'BK tidak ditemukan'
            ], 404);
        }

        $bk->user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'BK berhasil dihapus'
        ]);
    }
}
