<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    /**
     * Menampilkan daftar dokter
     */
    public function index()
    {
        $dokter = Dokter::with('poli')->latest()->paginate(10);
        return view('admin.dokter.index', compact('dokter'));
    }

    /**
     * Menampilkan form untuk membuat dokter baru
     */
    public function create()
    {
        $poli = Poli::where('status', 'aktif')->get();
        return view('admin.dokter.create', compact('poli'));
    }

    /**
     * Menyimpan data dokter baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'poli_id'      => 'required|exists:poli,id',
            'nama'         => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status'       => 'required|in:aktif,cuti,off',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $foto         = $request->file('foto');
            $path         = $foto->store('dokter', 'public');
            $data['foto'] = $path;
        }

        // Simpan dokter baru
        $dokter = Dokter::create($data);

        // Buat jadwal default untuk dokter baru
        $this->createDefaultJadwalDokter($dokter);

        return redirect()->route('admin.dokter.show', $dokter->id)
            ->with('success', 'Data dokter berhasil ditambahkan. Silahkan edit jadwal dokter sesuai kebutuhan.');
    }

    /**
     * Membuat jadwal default untuk dokter baru
     */
    private function createDefaultJadwalDokter($dokter)
    {
        // Daftar hari untuk jadwal
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // Jam praktek default
        $jamMulai   = '08:00';
        $jamSelesai = '16:00';

        // Buat jadwal default untuk hari Senin-Jumat
        foreach ($hari as $h) {
            JadwalDokter::create([
                'dokter_id'   => $dokter->id,
                'hari'        => $h,
                'jam_mulai'   => $jamMulai,
                'jam_selesai' => $jamSelesai,
                'status'      => 'tidak aktif', // Default tidak aktif hingga diatur manual
            ]);
        }
    }

    /**
     * Menampilkan detail dokter beserta jadwalnya
     */
    public function show(Dokter $dokter)
    {
        $dokter->load(['poli', 'jadwal']);

        // Jika dokter tidak memiliki jadwal sama sekali, buat jadwal default
        if ($dokter->jadwal->isEmpty()) {
            $this->createDefaultJadwalDokter($dokter);
            // Reload jadwal
            $dokter->load('jadwal');
        }

        return view('admin.dokter.show', compact('dokter'));
    }

    /**
     * Menampilkan form untuk mengedit dokter
     */
    public function edit(Dokter $dokter)
    {
        $poli = Poli::where('status', 'aktif')->get();
        return view('admin.dokter.edit', compact('dokter', 'poli'));
    }

    /**
     * Menyimpan perubahan data dokter
     */
    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'poli_id'      => 'required|exists:poli,id',
            'nama'         => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status'       => 'required|in:aktif,cuti,off',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($dokter->foto) {
                Storage::disk('public')->delete($dokter->foto);
            }

            $foto         = $request->file('foto');
            $path         = $foto->store('dokter', 'public');
            $data['foto'] = $path;
        }

        $dokter->update($data);

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil diperbarui');
    }

    /**
     * Menghapus data dokter
     */
    public function destroy(Dokter $dokter)
    {
        // Periksa apakah dokter memiliki pendaftaran terkait
        if ($dokter->pendaftaran()->count() > 0) {
            return redirect()->route('admin.dokter.index')
                ->with('error', 'Dokter tidak dapat dihapus karena masih memiliki data pendaftaran terkait.');
        }

        // Hapus foto jika ada
        if ($dokter->foto) {
            Storage::disk('public')->delete($dokter->foto);
        }

        // Hapus semua jadwal dokter terlebih dahulu
        $dokter->jadwal()->delete();

        // Hapus dokter
        $dokter->delete();

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil dihapus');
    }

    /**
     * Menampilkan jadwal dokter
     */
    public function jadwal(Dokter $dokter)
    {
        $dokter->load('jadwal', 'poli');

        // Jika dokter tidak memiliki jadwal sama sekali, buat jadwal default
        if ($dokter->jadwal->isEmpty()) {
            $this->createDefaultJadwalDokter($dokter);
            // Reload jadwal
            $dokter->load('jadwal');
            // Tambahkan pesan info
            session()->flash('info', 'Jadwal default telah dibuat untuk dokter ini. Silakan sesuaikan jadwal sesuai kebutuhan.');
        }

        return view('admin.dokter.show', compact('dokter'));
    }

    /**
     * Menampilkan form untuk menambah jadwal dokter
     */
    public function createJadwal(Dokter $dokter)
    {
        // Periksa apakah dokter memiliki jadwal
        if ($dokter->jadwal->isEmpty()) {
            // Buat jadwal default jika belum ada
            $this->createDefaultJadwalDokter($dokter);
            // Reload jadwal
            $dokter->load('jadwal');

            // Tambahkan pesan info
            session()->flash('info', 'Jadwal default telah dibuat untuk dokter ini. Anda juga dapat menambahkan jadwal baru.');
        }

        return view('admin.dokter.create_jadwal', compact('dokter'));
    }

    /**
     * Menyimpan jadwal dokter baru
     */
    public function storeJadwal(Request $request, Dokter $dokter)
    {
        $request->validate([
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status'      => 'required|in:aktif,tidak aktif',
        ]);

        // Periksa apakah dokter memiliki jadwal
        if ($dokter->jadwal->isEmpty()) {
            // Buat jadwal default
            $this->createDefaultJadwalDokter($dokter);
            // Reload jadwal
            $dokter->load('jadwal');
        }

        // Periksa apakah jadwal untuk hari yang sama sudah ada
        $existingJadwal = $dokter->jadwal()->where('hari', $request->hari)->first();
        if ($existingJadwal) {
            // Jika jadwal sudah ada, perbarui saja daripada menampilkan error
            $existingJadwal->update([
                'jam_mulai'   => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status'      => $request->status,
            ]);

            return redirect()->route('admin.dokter.show', $dokter->id)
                ->with('success', 'Jadwal dokter berhasil diperbarui');
        }

        $jadwal = new JadwalDokter($request->all());
        $dokter->jadwal()->save($jadwal);

        return redirect()->route('admin.dokter.show', $dokter->id)
            ->with('success', 'Jadwal dokter berhasil ditambahkan');
    }

    /**
     * Menampilkan form untuk mengedit jadwal dokter
     */
    public function editJadwal(Dokter $dokter, JadwalDokter $jadwal)
    {
        // Periksa apakah dokter memiliki jadwal
        if ($dokter->jadwal->isEmpty()) {
            // Buat jadwal default jika belum ada
            $this->createDefaultJadwalDokter($dokter);
            // Reload jadwal
            $dokter->load('jadwal');

            // Redirect ke halaman show dengan pesan
            return redirect()->route('admin.dokter.show', $dokter->id)
                ->with('info', 'Jadwal default telah dibuat untuk dokter ini. Silakan pilih jadwal yang ingin diedit.');
        }

        // Pastikan jadwal ini milik dokter yang dimaksud
        if ($jadwal->dokter_id != $dokter->id) {
            // Coba temukan jadwal dengan hari yang sama sebagai alternatif
            $alternatifJadwal = $dokter->jadwal()->where('hari', $jadwal->hari)->first();

            if ($alternatifJadwal) {
                return redirect()->route('admin.dokter.jadwal.edit', [$dokter->id, $alternatifJadwal->id])
                    ->with('info', 'Jadwal yang dimaksud telah disesuaikan.');
            }

            return redirect()->route('admin.dokter.show', $dokter->id)
                ->with('error', 'Jadwal tidak ditemukan');
        }

        return view('admin.dokter.edit_jadwal', compact('dokter', 'jadwal'));
    }

    /**
     * Menyimpan perubahan jadwal dokter
     */
    public function updateJadwal(Request $request, Dokter $dokter, JadwalDokter $jadwal)
    {
        // Periksa apakah dokter memiliki jadwal
        if ($dokter->jadwal->isEmpty()) {
            // Buat jadwal default jika belum ada
            $this->createDefaultJadwalDokter($dokter);

            // Redirect ke halaman show dengan pesan
            return redirect()->route('admin.dokter.show', $dokter->id)
                ->with('info', 'Jadwal default telah dibuat untuk dokter ini. Silakan pilih jadwal yang ingin diperbarui.');
        }

        // Pastikan jadwal ini milik dokter yang dimaksud
        if ($jadwal->dokter_id != $dokter->id) {
            // Coba temukan jadwal dengan hari yang sama sebagai alternatif
            $alternatifJadwal = $dokter->jadwal()->where('hari', $request->hari)->first();

            if ($alternatifJadwal) {
                // Update jadwal alternatif yang ditemukan
                $alternatifJadwal->update($request->all());

                return redirect()->route('admin.dokter.show', $dokter->id)
                    ->with('success', 'Jadwal dokter berhasil diperbarui');
            }

            return redirect()->route('admin.dokter.show', $dokter->id)
                ->with('error', 'Jadwal tidak ditemukan');
        }

        $request->validate([
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status'      => 'required|in:aktif,tidak aktif',
        ]);

        // Periksa apakah jadwal untuk hari yang sama sudah ada (kecuali jadwal saat ini)
        $existingJadwal = $dokter->jadwal()
            ->where('hari', $request->hari)
            ->where('id', '!=', $jadwal->id)
            ->first();

        if ($existingJadwal) {
            return redirect()->back()
                ->with('error', 'Jadwal untuk hari ' . $request->hari . ' sudah ada!')
                ->withInput();
        }

        $jadwal->update($request->all());

        return redirect()->route('admin.dokter.show', $dokter->id)
            ->with('success', 'Jadwal dokter berhasil diperbarui');
    }

    /**
     * Menghapus jadwal dokter
     */
    public function destroyJadwal(Dokter $dokter, JadwalDokter $jadwal)
    {
        // Periksa apakah dokter memiliki jadwal
        if ($dokter->jadwal->isEmpty()) {
            // Buat jadwal default jika belum ada
            $this->createDefaultJadwalDokter($dokter);
            // Reload jadwal
            $dokter->load('jadwal');

            // Redirect ke halaman show dengan pesan
            return redirect()->route('admin.dokter.show', $dokter->id)
                ->with('info', 'Jadwal default telah dibuat untuk dokter ini. Silakan pilih jadwal yang ingin dihapus.');
        }

        // Pastikan jadwal ini milik dokter yang dimaksud
        if ($jadwal->dokter_id != $dokter->id) {
            // Coba temukan jadwal dengan id yang sama (jika ada)
            $alternatifJadwal = $dokter->jadwal()->where('id', $jadwal->id)->first();

            if ($alternatifJadwal) {
                $alternatifJadwal->delete();
                return redirect()->route('admin.dokter.show', $dokter->id)
                    ->with('success', 'Jadwal dokter berhasil dihapus');
            }

            return redirect()->route('admin.dokter.show', $dokter->id)
                ->with('error', 'Jadwal tidak ditemukan');
        }

        $jadwal->delete();

        return redirect()->route('admin.dokter.show', $dokter->id)
            ->with('success', 'Jadwal dokter berhasil dihapus');
    }
}
