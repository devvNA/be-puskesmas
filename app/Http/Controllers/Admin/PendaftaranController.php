<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan daftar pendaftaran pada hari ini
     */
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $pendaftaran = Pendaftaran::with(['pasien', 'poli', 'dokter'])
            ->where('tanggal_pendaftaran', $today)
            ->orderBy('no_antrian', 'asc')
            ->paginate(10);

        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    /**
     * Menampilkan form untuk membuat pendaftaran baru
     */
    public function create()
    {
        $pasien = Pasien::orderBy('nama', 'asc')->get();
        $poli = Poli::where('status', 'aktif')->get();
        $dokter = Dokter::where('status', 'aktif')->get();

        return view('admin.pendaftaran.create', compact('pasien', 'poli', 'dokter'));
    }

    /**
     * Menyimpan data pendaftaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'poli_id' => 'required|exists:poli,id',
            'dokter_id' => 'nullable|exists:dokter,id',
            'tanggal_pendaftaran' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->all();

        // Hitung nomor antrian untuk poli tertentu pada tanggal tersebut
        $tanggal = $request->tanggal_pendaftaran;
        $poli_id = $request->poli_id;

        $lastAntrian = Pendaftaran::where('tanggal_pendaftaran', $tanggal)
            ->where('poli_id', $poli_id)
            ->max('no_antrian');

        $data['no_antrian'] = $lastAntrian ? $lastAntrian + 1 : 1;
        $data['status_kehadiran'] = 'belum hadir';

        Pendaftaran::create($data);

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Pendaftaran pasien berhasil ditambahkan');
    }

    /**
     * Menampilkan detail pendaftaran
     */
    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['pasien', 'poli', 'dokter']);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    /**
     * Menampilkan form untuk mengedit pendaftaran
     */
    public function edit(Pendaftaran $pendaftaran)
    {
        $pasien = Pasien::orderBy('nama', 'asc')->get();
        $poli = Poli::where('status', 'aktif')->get();
        $dokter = Dokter::where('status', 'aktif')->get();

        return view('admin.pendaftaran.edit', compact('pendaftaran', 'pasien', 'poli', 'dokter'));
    }

    /**
     * Menyimpan perubahan data pendaftaran
     */
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'poli_id' => 'required|exists:poli,id',
            'dokter_id' => 'nullable|exists:dokter,id',
            'tanggal_pendaftaran' => 'required|date',
            'status_kehadiran' => 'required|in:belum hadir,sudah hadir',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->all();

        // Jika status kehadiran diubah menjadi "sudah hadir", catat waktu kehadiran
        if ($request->status_kehadiran === 'sudah hadir' && $pendaftaran->status_kehadiran === 'belum hadir') {
            $data['waktu_hadir'] = Carbon::now();
        }

        $pendaftaran->update($data);

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil diperbarui');
    }

    /**
     * Menghapus data pendaftaran
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->delete();

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Data pendaftaran berhasil dihapus');
    }

    /**
     * Mengubah status kehadiran pasien
     */
    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status_kehadiran' => 'required|in:belum hadir,sudah hadir',
        ]);

        $pendaftaran->status_kehadiran = $request->status_kehadiran;

        if ($request->status_kehadiran === 'sudah hadir' && $pendaftaran->waktu_hadir === null) {
            $pendaftaran->waktu_hadir = Carbon::now();
        }

        $pendaftaran->save();

        return redirect()->back()->with('success', 'Status kehadiran berhasil diperbarui');
    }

    /**
     * Mencari pendaftaran berdasarkan tanggal
     */
    public function searchByDate(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $pendaftaran = Pendaftaran::with(['pasien', 'poli', 'dokter'])
            ->where('tanggal_pendaftaran', $tanggal)
            ->orderBy('no_antrian', 'asc')
            ->paginate(10);

        return view('admin.pendaftaran.index', compact('pendaftaran', 'tanggal'));
    }

    /**
     * Memproses QR Code untuk kehadiran
     */
    public function scanQR(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);
        $pendaftaran->status_kehadiran = 'sudah hadir';
        $pendaftaran->waktu_hadir = Carbon::now();
        $pendaftaran->save();

        return response()->json([
            'success' => true,
            'message' => 'Kehadiran pasien berhasil dicatat',
            'data' => $pendaftaran
        ]);
    }
}
