<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    /**
     * Menampilkan daftar poli
     */
    public function index()
    {
        $poli = Poli::withCount('jadwal')->latest()->paginate(10);
        return view('admin.poli.index', compact('poli'));
    }

    /**
     * Menampilkan form untuk membuat poli baru
     */
    public function create()
    {
        return view('admin.poli.create');
    }

    /**
     * Menyimpan data poli baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kuota_harian' => 'required|integer|min:0',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        Poli::create($request->all());

        return redirect()->route('admin.poli.index')
            ->with('success', 'Data poli berhasil ditambahkan');
    }

    /**
     * Menampilkan detail poli beserta jadwalnya
     */
    public function show(Poli $poli)
    {
        $poli->load('jadwal');
        return view('admin.poli.show', compact('poli'));
    }

    /**
     * Menampilkan form untuk mengedit poli
     */
    public function edit(Poli $poli)
    {
        return view('admin.poli.edit', compact('poli'));
    }

    /**
     * Menyimpan perubahan data poli
     */
    public function update(Request $request, Poli $poli)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kuota_harian' => 'required|integer|min:0',
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        $poli->update($request->all());

        return redirect()->route('admin.poli.index')
            ->with('success', 'Data poli berhasil diperbarui');
    }

    /**
     * Menghapus data poli
     */
    public function destroy(Poli $poli)
    {
        $poli->delete();

        return redirect()->route('admin.poli.index')
            ->with('success', 'Data poli berhasil dihapus');
    }
}
