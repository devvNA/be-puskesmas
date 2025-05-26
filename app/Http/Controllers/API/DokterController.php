<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Menampilkan daftar semua dokter
     */
    public function index()
    {
        $dokter = Dokter::all();
        return response()->json([
            'success' => true,
            'data'    => $dokter,
        ]);
    }

    /**
     * Menampilkan detail dokter berdasarkan ID
     */
    public function show($id)
    {
        $dokter = Dokter::with('poli')->find($id);

        if (! $dokter) {
            return response()->json([
                'success' => false,
                'message' => 'Dokter tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $dokter,
        ]);
    }

    /**
     * Menampilkan daftar dokter berdasarkan ID Poli
     */
    public function getByPoli($poliId)
    {
        $dokter = Dokter::with('poli', 'jadwal')
            ->where('poli_id', $poliId)
            ->get();

        if ($dokter->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada dokter ditemukan untuk poli ini',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $dokter,
        ]);
    }

    /**
     * Menampilkan jadwal dokter
     */
    public function jadwal(Request $request)
    {
        $query = JadwalDokter::with(['dokter', 'dokter.poli']);

        // Filter by dokter_id jika ada
        if ($request->has('dokter_id')) {
            $query->where('dokter_id', $request->dokter_id);
        }

        // Filter by poli_id jika ada
        if ($request->has('poli_id')) {
            $query->whereHas('dokter', function ($q) use ($request) {
                $q->where('poli_id', $request->poli_id);
            });
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
