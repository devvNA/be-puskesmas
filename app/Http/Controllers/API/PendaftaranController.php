<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan daftar pendaftaran user yang sedang login
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

        $pendaftaran = Pendaftaran::with(['dokter', 'dokter.poli'])
            ->where('pasien_id', $pasien->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $pendaftaran,
        ]);
    }

    /**
     * Menyimpan pendaftaran baru
     */
    public function store(Request $request)
    {
        $user   = $request->user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        if (! $pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'dokter_id'       => 'required|exists:dokter,id',
            'tanggal'         => 'required|date|after_or_equal:today',
            'keluhan'         => 'required|string',
            'jenis_kunjungan' => 'required|in:Baru,Lama',
            'cara_bayar'      => 'required|in:Umum,BPJS,Asuransi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Validasi jadwal dokter
        $hari         = date('l', strtotime($request->tanggal));
        $jadwalDokter = JadwalDokter::where('dokter_id', $request->dokter_id)
            ->where('hari', $hari)
            ->first();

        if (! $jadwalDokter) {
            return response()->json([
                'success' => false,
                'message' => 'Dokter tidak tersedia pada hari tersebut',
            ], 422);
        }

        // Cek jumlah pendaftaran pada tanggal yang sama
        $existingPendaftaran = Pendaftaran::where('dokter_id', $request->dokter_id)
            ->where('tanggal', $request->tanggal)
            ->count();

        if ($existingPendaftaran >= 20) { // Limit per hari
            return response()->json([
                'success' => false,
                'message' => 'Kuota pendaftaran sudah penuh untuk tanggal tersebut',
            ], 422);
        }

        // Buat nomor antrian
        $nomorAntrian = $existingPendaftaran + 1;

        $pendaftaran = Pendaftaran::create([
            'pasien_id'       => $pasien->id,
            'dokter_id'       => $request->dokter_id,
            'tanggal'         => $request->tanggal,
            'nomor_antrian'   => $nomorAntrian,
            'keluhan'         => $request->keluhan,
            'jenis_kunjungan' => $request->jenis_kunjungan,
            'cara_bayar'      => $request->cara_bayar,
            'status'          => 'Menunggu',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil',
            'data'    => $pendaftaran,
        ], 201);
    }

    /**
     * Menampilkan detail pendaftaran
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

        $pendaftaran = Pendaftaran::with(['dokter', 'dokter.poli'])
            ->where('id', $id)
            ->where('pasien_id', $pasien->id)
            ->first();

        if (! $pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pendaftaran,
        ]);
    }

    /**
     * Menghapus pendaftaran
     */
    public function destroy(Request $request, $id)
    {
        $user   = $request->user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        if (! $pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        $pendaftaran = Pendaftaran::where('id', $id)
            ->where('pasien_id', $pasien->id)
            ->where('status', 'Menunggu') // Hanya bisa batalkan yang masih menunggu
            ->first();

        if (! $pendaftaran) {
            return response()->json([
                'success' => false,
                'message' => 'Pendaftaran tidak ditemukan atau tidak dapat dibatalkan',
            ], 404);
        }

        $pendaftaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil dibatalkan',
        ]);
    }
}
