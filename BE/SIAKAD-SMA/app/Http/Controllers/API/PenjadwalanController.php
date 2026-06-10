<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\BK;
use App\Models\Penjadwalan;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PenjadwalanController extends Controller
{
    private function currentBK(Request $request)
    {
        return BK::where('user_id', $request->user()->id)->first();
    }

    private function currentSiswa(Request $request)
    {
        return Siswa::where('user_id', $request->user()->id)->first();
    }

    private function userRole(Request $request)
    {
        return $request->user()->role->name ?? null;
    }

    // Tampilkan semua penjadwalan
    public function index(Request $request)
    {
        if ($this->userRole($request) === 'BK') {
            $bk = $this->currentBK($request);
            if (!$bk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data BK tidak ditemukan untuk user ini'
                ], 403);
            }

            $penjadwalans = Penjadwalan::with(['siswa', 'bk', 'feedback.bk'])
                ->where('bk_id', $bk->id)
                ->orderBy('tanggal', 'desc')
                ->orderBy('waktu', 'desc')
                ->get();
        } else {
            $penjadwalans = Penjadwalan::with(['siswa', 'bk', 'feedback.bk'])
                ->orderBy('tanggal', 'desc')
                ->orderBy('waktu', 'desc')
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $penjadwalans
        ]);
    }

    // Tambah penjadwalan baru
    public function store(Request $request)
    {
        $role = $this->userRole($request);

        if ($role === 'Siswa') {
            $siswa = $this->currentSiswa($request);
            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data siswa tidak ditemukan untuk user ini'
                ], 403);
            }

            $request->validate([
                'tanggal' => 'required|date',
                'waktu' => 'required',
                'bk_id' => 'required|exists:b_k_s,id',
                'keterangan' => 'nullable|string',
            ]);

            $penjadwalan = Penjadwalan::create([
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'siswa_id' => $siswa->id,
                'bk_id' => $request->bk_id,
                'status' => '0',
                'keterangan' => $request->keterangan,
            ]);
        } elseif ($role === 'BK') {
            $bk = $this->currentBK($request);
            if (!$bk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data BK tidak ditemukan untuk user ini'
                ], 403);
            }

            $request->validate([
                'tanggal' => 'required|date',
                'waktu' => 'required',
                'siswa_id' => 'required|exists:siswas,id',
                'status' => 'nullable|in:0,1',
                'keterangan' => 'nullable|string',
            ]);

            $penjadwalan = Penjadwalan::create([
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'siswa_id' => $request->siswa_id,
                'bk_id' => $bk->id,
                'status' => $request->status ?? '1',
                'keterangan' => $request->keterangan,
            ]);
        } else {
            $request->validate([
                'tanggal' => 'required|date',
                'waktu' => 'required',
                'siswa_id' => 'required|exists:siswas,id',
                'bk_id' => 'required|exists:b_k_s,id',
                'status' => 'nullable|in:0,1',
                'keterangan' => 'nullable|string',
            ]);

            $penjadwalan = Penjadwalan::create($request->all());
        }

        return response()->json([
            'success' => true,
            'message' => 'Penjadwalan berhasil ditambahkan',
            'data' => $penjadwalan->load(['siswa', 'bk'])
        ], 201);
    }

    // Tampilkan satu penjadwalan
    public function show(Request $request, $id)
    {
        $penjadwalan = Penjadwalan::with(['siswa', 'bk'])->find($id);

        if (!$penjadwalan) {
            return response()->json([
                'success' => false,
                'message' => 'Penjadwalan tidak ditemukan'
            ], 404);
        }

        if ($this->userRole($request) === 'BK') {
            $bk = $this->currentBK($request);
            if (!$bk || $penjadwalan->bk_id !== $bk->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak untuk penjadwalan ini'
                ], 403);
            }
        }

        if ($this->userRole($request) === 'Siswa') {
            $siswa = $this->currentSiswa($request);
            if (!$siswa || $penjadwalan->siswa_id !== $siswa->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak untuk penjadwalan ini'
                ], 403);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $penjadwalan
        ]);
    }

    // Update penjadwalan
    public function update(Request $request, $id)
    {
        $penjadwalan = Penjadwalan::find($id);

        if (!$penjadwalan) {
            return response()->json([
                'success' => false,
                'message' => 'Penjadwalan tidak ditemukan'
            ], 404);
        }

        if ($this->userRole($request) === 'BK') {
            $bk = $this->currentBK($request);
            if (!$bk || $penjadwalan->bk_id !== $bk->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak untuk penjadwalan ini'
                ], 403);
            }
        }

        $request->validate([
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'siswa_id' => 'required|exists:siswas,id',
            'bk_id' => 'required|exists:b_k_s,id',
            'status' => 'nullable|in:0,1',
            'keterangan' => 'nullable|string',
        ]);

        $penjadwalan->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Penjadwalan berhasil diupdate',
            'data' => $penjadwalan->load(['siswa', 'bk'])
        ]);
    }

    // Hapus penjadwalan
    public function destroy(Request $request, $id)
    {
        $penjadwalan = Penjadwalan::find($id);

        if (!$penjadwalan) {
            return response()->json([
                'success' => false,
                'message' => 'Penjadwalan tidak ditemukan'
            ], 404);
        }

        if ($this->userRole($request) === 'BK') {
            $bk = $this->currentBK($request);
            if (!$bk || $penjadwalan->bk_id !== $bk->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak untuk penjadwalan ini'
                ], 403);
            }
        }

        if ($this->userRole($request) === 'Siswa') {
            $siswa = $this->currentSiswa($request);
            if (!$siswa || $penjadwalan->siswa_id !== $siswa->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak untuk penjadwalan ini'
                ], 403);
            }
        }

        $penjadwalan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Penjadwalan berhasil dihapus'
        ]);
    }

    // Get penjadwalan by siswa_id
    public function getPenjadwalanSiswa(Request $request, $siswa_id)
    {
        if ($this->userRole($request) === 'Siswa') {
            $siswa = $this->currentSiswa($request);
            if (!$siswa || $siswa->id != $siswa_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak untuk data siswa ini'
                ], 403);
            }
        }

        $penjadwalans = Penjadwalan::with(['siswa', 'bk'])
            ->where('siswa_id', $siswa_id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $penjadwalans
        ]);
    }

    // Approve/konfirmasi penjadwalan
    public function approve(Request $request, $id)
    {
        $penjadwalan = Penjadwalan::find($id);

        if (!$penjadwalan) {
            return response()->json([
                'success' => false,
                'message' => 'Penjadwalan tidak ditemukan'
            ], 404);
        }

        $bk = $this->currentBK($request);
        if (!$bk || $penjadwalan->bk_id !== $bk->id) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak untuk penjadwalan ini'
            ], 403);
        }

        $penjadwalan->update(['status' => '1']);

        return response()->json([
            'success' => true,
            'message' => 'Penjadwalan berhasil dikonfirmasi',
            'data' => $penjadwalan->load(['siswa', 'bk'])
        ]);
    }

    // Reject/tolak penjadwalan
    public function reject(Request $request, $id)
    {
        $penjadwalan = Penjadwalan::find($id);

        if (!$penjadwalan) {
            return response()->json([
                'success' => false,
                'message' => 'Penjadwalan tidak ditemukan'
            ], 404);
        }

        $bk = $this->currentBK($request);
        if (!$bk || $penjadwalan->bk_id !== $bk->id) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak untuk penjadwalan ini'
            ], 403);
        }

        $penjadwalan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Penjadwalan berhasil ditolak dan dihapus'
        ]);
    }
}
