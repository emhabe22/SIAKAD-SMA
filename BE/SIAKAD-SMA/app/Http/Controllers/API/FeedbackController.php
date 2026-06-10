<?php

namespace App\Http\Controllers\API;

use App\Models\Feedback;
use App\Models\Penjadwalan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    /**
     * Get all feedback for a specific penjadwalan (for BK to see/edit)
     */
    public function getByPenjadwalan($penjadwalan_id)
    {
        $feedback = Feedback::where('penjadwalan_id', $penjadwalan_id)
            ->with(['bk', 'siswa'])
            ->first();

        return response()->json([
            'success' => true,
            'data' => $feedback
        ]);
    }

    /**
     * Get all feedback received by a siswa (for siswa to view)
     */
    public function getSiswaFeedback($siswa_id)
    {
        $feedbacks = Feedback::where('siswa_id', $siswa_id)
            ->with(['penjadwalan', 'bk'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $feedbacks
        ]);
    }

    /**
     * Create feedback for a penjadwalan
     */
    public function store(Request $request, $penjadwalan_id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|min:10'
        ]);

        // Get penjadwalan to ensure it exists and get siswa_id
        $penjadwalan = Penjadwalan::findOrFail($penjadwalan_id);

        // Check if status is approved (1)
        if ($penjadwalan->status != 1 && $penjadwalan->status != '1') {
            return response()->json([
                'success' => false,
                'message' => 'Feedback hanya bisa diberikan untuk konseling yang sudah selesai'
            ], 422);
        }

        // Check if feedback already exists for this penjadwalan
        $existingFeedback = Feedback::where('penjadwalan_id', $penjadwalan_id)->first();
        if ($existingFeedback) {
            return response()->json([
                'success' => false,
                'message' => 'Feedback untuk konseling ini sudah ada'
            ], 422);
        }

        $feedback = Feedback::create([
            'penjadwalan_id' => $penjadwalan_id,
            'bk_id' => $request->user()->bk->id,
            'siswa_id' => $penjadwalan->siswa_id,
            'judul' => $request->judul,
            'isi' => $request->isi
        ]);

        return response()->json([
            'success' => true,
            'data' => $feedback->load(['bk', 'siswa']),
            'message' => 'Feedback berhasil dibuat'
        ], 201);
    }

    /**
     * Update feedback
     */
    public function update(Request $request, $feedback_id)
    {
        $feedback = Feedback::findOrFail($feedback_id);

        // Ensure user is the one who created feedback
        if ($feedback->bk_id != $request->user()->bk->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak mengubah feedback ini'
            ], 403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|min:10'
        ]);

        $feedback->update([
            'judul' => $request->judul,
            'isi' => $request->isi
        ]);

        return response()->json([
            'success' => true,
            'data' => $feedback->load(['bk', 'siswa']),
            'message' => 'Feedback berhasil diubah'
        ]);
    }

    /**
     * Delete feedback
     */
    public function destroy(Request $request, $feedback_id)
    {
        $feedback = Feedback::findOrFail($feedback_id);

        // Ensure user is the one who created feedback
        if ($feedback->bk_id != $request->user()->bk->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak berhak menghapus feedback ini'
            ], 403);
        }

        $feedback->delete();

        return response()->json([
            'success' => true,
            'message' => 'Feedback berhasil dihapus'
        ]);
    }
}
