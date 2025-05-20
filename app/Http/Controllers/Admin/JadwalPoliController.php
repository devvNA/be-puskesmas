<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPoli;
use App\Models\Poli;
use Illuminate\Http\Request;

class JadwalPoliController extends Controller
{
    /**
     * Menampilkan daftar jadwal poli berdasarkan poli tertentu
     */
    public function index(Poli $poli)
    {
        $jadwal = $poli->jadwal;
        return view('admin.jadwal.index', compact('poli', 'jadwal'));
    }

    /**
     * Menampilkan form untuk membuat jadwal poli baru
     */
    public function create(Poli $poli)
    {
        return view('admin.jadwal.create', compact('poli'));
    }

    /**
     * Menyimpan jadwal poli baru
     */
    public function store(Request $request, Poli $poli)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        // Periksa apakah jadwal untuk hari yang sama sudah ada
        $existingJadwal = $poli->jadwal()->where('hari', $request->hari)->first();
        if ($existingJadwal) {
            return redirect()->back()
                ->with('error', 'Jadwal untuk hari ' . $request->hari . ' sudah ada!')
                ->withInput();
        }

        $jadwal = new JadwalPoli($request->all());
        $poli->jadwal()->save($jadwal);

        return redirect()->route('admin.jadwal.index', $poli->id)
            ->with('success', 'Jadwal poli berhasil ditambahkan');
    }

    /**
     * Menampilkan form untuk mengedit jadwal poli
     */
    public function edit(Poli $poli, JadwalPoli $jadwal)
    {
        return view('admin.jadwal.edit', compact('poli', 'jadwal'));
    }

    /**
     * Menyimpan perubahan jadwal poli
     */
    public function update(Request $request, Poli $poli, JadwalPoli $jadwal)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        // Periksa apakah jadwal untuk hari yang sama sudah ada, kecuali jadwal yang sedang diedit
        $existingJadwal = $poli->jadwal()
            ->where('hari', $request->hari)
            ->where('id', '!=', $jadwal->id)
            ->first();

        if ($existingJadwal) {
            return redirect()->back()
                ->with('error', 'Jadwal untuk hari ' . $request->hari . ' sudah ada!')
                ->withInput();
        }

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index', $poli->id)
            ->with('success', 'Jadwal poli berhasil diperbarui');
    }

    /**
     * Menghapus jadwal poli
     */
    public function destroy(Poli $poli, JadwalPoli $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index', $poli->id)
            ->with('success', 'Jadwal poli berhasil dihapus');
    }
}
