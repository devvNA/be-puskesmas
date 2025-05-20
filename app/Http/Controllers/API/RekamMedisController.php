<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar rekam medis untuk pasien yang login
     */
    public function index(Request $request)
    {
        $user   = $request->user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        if (! $pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        $rekamMedis = RekamMedis::with(['dokter', 'dokter.poli', 'pendaftaran', 'obat'])
            ->where('pasien_id', $pasien->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $rekamMedis,
        ]);
    }

    /**
     * Menampilkan detail rekam medis
     */
    public function show(Request $request, $id)
    {
        $user   = $request->user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        if (! $pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        $rekamMedis = RekamMedis::with(['dokter', 'dokter.poli', 'pendaftaran', 'obat', 'filePendukung'])
            ->where('id', $id)
            ->where('pasien_id', $pasien->id)
            ->first();

        if (! $rekamMedis) {
            return response()->json([
                'success' => false,
                'message' => 'Rekam medis tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $rekamMedis,
        ]);
    }
}
