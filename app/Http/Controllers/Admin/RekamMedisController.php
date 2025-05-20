<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\FilePendukung;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\Poli;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar rekam medis
     */
    public function index()
    {
        $rekamMedis = RekamMedis::with(['pasien', 'dokter', 'poli'])
            ->latest()
            ->paginate(10);

        return view('admin.rekam_medis.index', compact('rekamMedis'));
    }

    /**
     * Menampilkan form untuk membuat rekam medis baru
     */
    public function create()
    {
        $pasien = Pasien::orderBy('nama', 'asc')->get();
        $pendaftaran = Pendaftaran::whereDate('tanggal_pendaftaran', today())->get();
        $dokter = Dokter::where('status', 'aktif')->get();
        $poli = Poli::where('status', 'aktif')->get();

        return view('admin.rekam_medis.create', compact('pasien', 'pendaftaran', 'dokter', 'poli'));
    }

    /**
     * Menyimpan data rekam medis baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'pendaftaran_id' => 'nullable|exists:pendaftaran,id',
            'dokter_id' => 'required|exists:dokter,id',
            'poli_id' => 'required|exists:poli,id',
            'tanggal_periksa' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosis' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep' => 'nullable|string',
            'catatan' => 'nullable|string',
            'file_pendukung' => 'nullable|array',
            'file_pendukung.*' => 'file|mimes:jpeg,png,jpg,pdf,doc,docx|max:5120',
            'jenis_file' => 'nullable|array',
            'jenis_file.*' => 'required_with:file_pendukung.*|string',
            'keterangan_file' => 'nullable|array',
            'keterangan_file.*' => 'nullable|string',
        ]);

        $rekamMedis = RekamMedis::create([
            'pasien_id' => $request->pasien_id,
            'pendaftaran_id' => $request->pendaftaran_id,
            'dokter_id' => $request->dokter_id,
            'poli_id' => $request->poli_id,
            'tanggal_periksa' => $request->tanggal_periksa,
            'keluhan' => $request->keluhan,
            'diagnosis' => $request->diagnosis,
            'tindakan' => $request->tindakan,
            'resep' => $request->resep,
            'catatan' => $request->catatan,
        ]);

        // Simpan file pendukung jika ada
        if ($request->hasFile('file_pendukung')) {
            foreach ($request->file('file_pendukung') as $key => $file) {
                $path = $file->store('rekam_medis', 'public');

                FilePendukung::create([
                    'rekam_medis_id' => $rekamMedis->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'jenis_file' => $request->jenis_file[$key] ?? 'lain-lain',
                    'file_path' => $path,
                    'keterangan' => $request->keterangan_file[$key] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.rekam-medis.show', $rekamMedis->id)
            ->with('success', 'Data rekam medis berhasil ditambahkan');
    }

    /**
     * Menampilkan detail rekam medis
     */
    public function show(RekamMedis $rekamMedis)
    {
        $rekamMedis->load(['pasien', 'dokter', 'poli', 'pendaftaran', 'filePendukung']);
        return view('admin.rekam_medis.show', compact('rekamMedis'));
    }

    /**
     * Menampilkan form untuk mengedit rekam medis
     */
    public function edit(RekamMedis $rekamMedis)
    {
        $pasien = Pasien::orderBy('nama', 'asc')->get();
        $pendaftaran = Pendaftaran::whereDate('tanggal_pendaftaran', $rekamMedis->tanggal_periksa)->get();
        $dokter = Dokter::get();
        $poli = Poli::get();

        $rekamMedis->load('filePendukung');

        return view('admin.rekam_medis.edit', compact('rekamMedis', 'pasien', 'pendaftaran', 'dokter', 'poli'));
    }

    /**
     * Menyimpan perubahan data rekam medis
     */
    public function update(Request $request, RekamMedis $rekamMedis)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'pendaftaran_id' => 'nullable|exists:pendaftaran,id',
            'dokter_id' => 'required|exists:dokter,id',
            'poli_id' => 'required|exists:poli,id',
            'tanggal_periksa' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosis' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep' => 'nullable|string',
            'catatan' => 'nullable|string',
            'file_pendukung' => 'nullable|array',
            'file_pendukung.*' => 'file|mimes:jpeg,png,jpg,pdf,doc,docx|max:5120',
            'jenis_file' => 'nullable|array',
            'jenis_file.*' => 'required_with:file_pendukung.*|string',
            'keterangan_file' => 'nullable|array',
            'keterangan_file.*' => 'nullable|string',
        ]);

        $rekamMedis->update([
            'pasien_id' => $request->pasien_id,
            'pendaftaran_id' => $request->pendaftaran_id,
            'dokter_id' => $request->dokter_id,
            'poli_id' => $request->poli_id,
            'tanggal_periksa' => $request->tanggal_periksa,
            'keluhan' => $request->keluhan,
            'diagnosis' => $request->diagnosis,
            'tindakan' => $request->tindakan,
            'resep' => $request->resep,
            'catatan' => $request->catatan,
        ]);

        // Simpan file pendukung baru jika ada
        if ($request->hasFile('file_pendukung')) {
            foreach ($request->file('file_pendukung') as $key => $file) {
                $path = $file->store('rekam_medis', 'public');

                FilePendukung::create([
                    'rekam_medis_id' => $rekamMedis->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'jenis_file' => $request->jenis_file[$key] ?? 'lain-lain',
                    'file_path' => $path,
                    'keterangan' => $request->keterangan_file[$key] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.rekam-medis.show', $rekamMedis->id)
            ->with('success', 'Data rekam medis berhasil diperbarui');
    }

    /**
     * Menghapus data rekam medis
     */
    public function destroy(RekamMedis $rekamMedis)
    {
        // Hapus file pendukung jika ada
        foreach ($rekamMedis->filePendukung as $file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        }

        $rekamMedis->delete();

        return redirect()->route('admin.rekam-medis.index')
            ->with('success', 'Data rekam medis berhasil dihapus');
    }

    /**
     * Menampilkan daftar rekam medis berdasarkan pasien
     */
    public function pasien(Pasien $pasien)
    {
        $rekamMedis = RekamMedis::with(['dokter', 'poli'])
            ->where('pasien_id', $pasien->id)
            ->latest()
            ->paginate(10);

        return view('admin.rekam_medis.pasien', compact('pasien', 'rekamMedis'));
    }

    /**
     * Menghapus file pendukung
     */
    public function destroyFile(FilePendukung $file)
    {
        $rekamMedisId = $file->rekam_medis_id;

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->route('admin.rekam-medis.edit', $rekamMedisId)
            ->with('success', 'File berhasil dihapus');
    }

    /**
     * Mencari pasien
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $pasien = Pasien::where('nama', 'like', "%$keyword%")
            ->orWhere('no_rm', 'like', "%$keyword%")
            ->orWhere('nik', 'like', "%$keyword%")
            ->paginate(10);

        return view('admin.rekam_medis.search', compact('pasien', 'keyword'));
    }

    /**
     * Membuat data JSON untuk QR Code
     *
     * @param RekamMedis $rekamMedis
     * @return \Illuminate\Http\JsonResponse
     */
    public function qrCodeData(RekamMedis $rekamMedis)
    {
        $data = [
            'rekam_medis_id' => $rekamMedis->id,
            'pasien' => [
                'id' => $rekamMedis->pasien_id,
                'nama' => $rekamMedis->pasien->nama,
                'no_rm' => $rekamMedis->pasien->no_rm
            ],
            'dokter' => [
                'id' => $rekamMedis->dokter_id,
                'nama' => $rekamMedis->dokter->nama
            ],
            'poli' => [
                'id' => $rekamMedis->poli_id,
                'nama' => $rekamMedis->poli->nama
            ],
            'tanggal_periksa' => $rekamMedis->tanggal_periksa,
            'diagnosis' => $rekamMedis->diagnosis,
            'url' => route('admin.rekam-medis.show', $rekamMedis->id)
        ];

        return response()->json($data);
    }
}
