<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JadwalPoli;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    /**
     * Menampilkan daftar semua poliklinik
     */
    public function index()
    {
        $poli = Poli::all();
        return response()->json([
            'success' => true,
            'data'    => $poli,
        ]);
    }

    /**
     * Menampilkan detail poliklinik berdasarkan ID
     */
    public function show($id)
    {
        $poli = Poli::with('dokter')->find($id);

        if (! $poli) {
            return response()->json([
                'success' => false,
                'message' => 'Poliklinik tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $poli,
        ]);
    }

    /**
     * Menampilkan jadwal poliklinik
     */
    public function jadwal(Request $request)
    {
        $query = JadwalPoli::with('poli');

        // Filter by poli_id jika ada
        if ($request->has('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        // Filter by hari jika ada
        if ($request->has('hari')) {
            $query->where('hari', $request->hari);
        }

        $jadwal = $query->get();

        return response()->json([
            'success' => true,
            'data'    => $jadwal,
        ]);
    }
}
