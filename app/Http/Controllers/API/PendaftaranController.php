<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\JadwalDokter;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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

        $pendaftaran = Pendaftaran::with(['dokter', 'dokter.poli', 'poli'])
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
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'no_rm'                => 'required|string',
            'no_bpjs'              => 'nullable|string',
            'nik'                  => 'nullable|string',
            'poli_id'              => 'required|exists:poli,id',
            'dokter_id'            => 'required|exists:dokter,id',
            'tanggal_pendaftaran'  => 'required|date|after_or_equal:today',
            'keterangan'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Cek pasien berdasarkan salah satu identifier (no_rm atau nik)
        $pasien = null;

        if ($request->no_rm) {
            $pasien = Pasien::where('no_rm', $request->no_rm)->first();
        } elseif ($request->nik) {
            $pasien = Pasien::where('nik', $request->nik)->first();
        } elseif ($request->no_bpjs) {
            $pasien = Pasien::where('no_bpjs', $request->no_bpjs)->first();
        }

        if (!$pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan. Pastikan No. RM, NIK, atau No. BPJS valid.',
            ], 404);
        }

        // Cek jumlah pendaftaran pada tanggal yang sama untuk poli tertentu
        $existingPendaftaran = Pendaftaran::where('poli_id', $request->poli_id)
            ->where('tanggal_pendaftaran', $request->tanggal_pendaftaran)
            ->count();

        if ($existingPendaftaran >= 20) { // Limit per hari
            return response()->json([
                'success' => false,
                'message' => 'Kuota pendaftaran sudah penuh untuk tanggal tersebut',
            ], 422);
        }

        // Buat nomor antrian
        // Ambil tanggal pendaftaran dari request (anggap valid dan format 'Y-m-d')
        $tanggalPendaftaran = $request->tanggal_pendaftaran;

        // Gunakan tanggal dari request sebagai dasar, bukan tanggal saat ini
        $waktuMulaiPraktik = Carbon::parse($tanggalPendaftaran . ' 08:00:00'); // Praktik mulai jam 8 pagi

        // Hitung no antrian dan waktu estimasi dipanggil
        $no_antrian = $existingPendaftaran + 1;
        $estimasiWaktuDipanggil = $waktuMulaiPraktik->copy()->addMinutes(($no_antrian - 1) * 15); // 15 menit per pasien

        // Format datetime final
        $waktuDipanggilDatetime = $estimasiWaktuDipanggil;

        $pendaftaran = Pendaftaran::create([
            'pasien_id'            => $pasien->id,
            'poli_id'              => $request->poli_id,
            'dokter_id'            => $request->dokter_id,
            'tanggal_pendaftaran'  => $request->tanggal_pendaftaran,
            'no_antrian'           => $no_antrian,
            'keterangan'           => $request->keterangan,
            'status_kehadiran'     => 'belum hadir',
            'waktu_dipanggil'      => $waktuDipanggilDatetime,
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

        $pendaftaran = Pendaftaran::with(['dokter', 'dokter.poli', 'poli'])
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
            ->where('status_kehadiran', 'belum hadir') // Hanya bisa batalkan yang belum hadir
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

    /**
     * Memproses QR Code untuk kehadiran
     */
    public function scanQR(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);
        $pendaftaran->status_kehadiran = 'sudah hadir';
        $pendaftaran->waktu_hadir = now();

        // Update estimasi waktu dipanggil berdasarkan kehadiran
        // Pasien yang sudah hadir akan dipanggil maksimal 30 menit setelah kedatangan
        $waktuHadir = now();
        $waktuDipanggil = $waktuHadir->copy()->addMinutes(30);
        $pendaftaran->waktu_dipanggil = $waktuDipanggil;

        $pendaftaran->save();

        return response()->json([
            'success' => true,
            'message' => 'Kehadiran pasien berhasil dicatat',
            'data'    => $pendaftaran
        ]);
    }

    /**
     * Menampilkan data pendaftaran untuk publik
     * Fungsi ini tidak memerlukan autentikasi
     */
    public function public(Request $request)
    {
        $today = now()->format('Y-m-d');
        $tanggal = $request->input('tanggal', $today);
        $poli_id = $request->input('poli_id');

        $query = Pendaftaran::with(['poli', 'dokter', 'pasien'])
            ->select('id', 'poli_id', 'dokter_id', 'pasien_id', 'tanggal_pendaftaran', 'no_antrian', 'status_kehadiran', 'waktu_hadir', 'waktu_dipanggil')
            ->where('tanggal_pendaftaran', $tanggal)
            ->orderBy('no_antrian', 'asc');

        if ($poli_id) {
            $query->where('poli_id', $poli_id);
        }

        $pendaftaran = $query->get();

        return response()->json([
            'success' => true,
            'tanggal' => $tanggal,
            'data'    => $pendaftaran->map(function ($item) {
                // Format data sesuai dengan UI mobile
                return [
                    'id' => $item->id,
                    'kode' => 'A' . str_pad($item->no_antrian, 3, '0', STR_PAD_LEFT),
                    'nama' => $item->pasien ? $item->pasien->nama : '-',
                    'poli' => $item->poli ? $item->poli->nama : '-',
                    'waktu' => $item->waktu_dipanggil ? Carbon::parse($item->waktu_dipanggil)->format('H:i') : '-',
                    'status' => $item->status_kehadiran,
                    'no_antrian' => $item->no_antrian,
                    'dokter_id' => $item->dokter_id,
                    'poli_id' => $item->poli_id,
                    'pasien_id' => $item->pasien_id,
                    'tanggal_pendaftaran' => $item->tanggal_pendaftaran
                ];
            }),
        ]);
    }
}
