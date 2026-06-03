<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JadwalSlot;
use Illuminate\Http\Request;

class JadwalSlotController extends Controller
{
    public function index(Request $request)
    {
        $query = JadwalSlot::query();

        if ($request->filled('hari')) {
            $query->where(function ($inner) use ($request) {
                $inner->whereNull('hari')
                    ->orWhere('hari', $request->hari);
            });
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $slots = $query->orderBy('jam_mulai')->get();

        return response()->json([
            'success' => true,
            'data' => $slots,
        ]);
    }
}
