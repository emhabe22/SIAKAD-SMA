<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Mapel;

class DashboardController extends Controller
{
    public function getAdminStats()
    {
        try {
            $siswas = Siswa::all();
            $gurus = Guru::all();
            $mapel = Mapel::all();

            return response()->json([
                'success' => true,
                'data' => [
                    'siswas' => $siswas,
                    'gurus' => $gurus,
                    'mapel' => $mapel
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dashboard',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
