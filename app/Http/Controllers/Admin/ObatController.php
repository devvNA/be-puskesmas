<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ObatController extends Controller
{
    /**
     * Menampilkan daftar obat
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $obat = Obat::latest()->paginate(10);
        return view('admin.obat.index', compact('obat'));
    }

    /**
     * Menampilkan form untuk membuat obat baru
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Menyimpan data obat baru
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_obat' => 'required|string|max:20|unique:obat,kode_obat',
            'nama_obat' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'satuan' => 'required|string|max:20',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'tanggal_kadaluarsa' => 'nullable|date',
        ]);

        // Siapkan data untuk disimpan
        $data = $request->all();
        $data['jenis_obat'] = $request->kategori; // Menyesuaikan field jenis_obat dengan kategori yang dipilih

        Obat::create($data);

        return redirect()->route('admin.obat.index')
            ->with('success', 'Data obat berhasil ditambahkan');
    }

    /**
     * Menampilkan detail obat
     *
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\View\View
     */
    public function show(Obat $obat)
    {
        return view('admin.obat.show', compact('obat'));
    }

    /**
     * Menampilkan form untuk mengedit obat
     *
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\View\View
     */
    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

    /**
     * Menyimpan perubahan data obat
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'kode_obat' => 'required|string|max:20|unique:obat,kode_obat,' . $obat->id,
            'nama_obat' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'satuan' => 'required|string|max:20',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'tanggal_kadaluarsa' => 'nullable|date',
        ]);

        // Siapkan data untuk diupdate
        $data = $request->all();
        $data['jenis_obat'] = $request->kategori; // Menyesuaikan field jenis_obat dengan kategori yang dipilih

        $obat->update($data);

        return redirect()->route('admin.obat.index')
            ->with('success', 'Data obat berhasil diperbarui');
    }

    /**
     * Menghapus data obat
     *
     * @param  \App\Models\Obat  $obat
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Obat $obat)
    {
        // Periksa apakah obat terkait dengan rekam medis
        if ($obat->rekamMedis()->count() > 0) {
            return redirect()->route('admin.obat.index')
                ->with('error', 'Obat tidak dapat dihapus karena masih terkait dengan data rekam medis');
        }

        $obat->delete();

        return redirect()->route('admin.obat.index')
            ->with('success', 'Data obat berhasil dihapus');
    }

    /**
     * Mencari data obat berdasarkan nama atau kode
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $search = $request->get('search');

        $obat = Obat::where('nama_obat', 'like', "%{$search}%")
            ->orWhere('kode_obat', 'like', "%{$search}%")
            ->orWhere('jenis_obat', 'like', "%{$search}%")
            ->latest()
            ->paginate(10);

        return view('admin.obat.index', compact('obat', 'search'));
    }

    /**
     * Menampilkan daftar obat yang kadaluarsa
     *
     * @return \Illuminate\View\View
     */
    public function kadaluarsa()
    {
        $today = now()->format('Y-m-d');
        $obat = Obat::whereDate('tanggal_kadaluarsa', '<=', $today)
            ->paginate(10);

        return view('admin.obat.index', compact('obat'));
    }

    /**
     * Menampilkan daftar obat dengan stok rendah
     *
     * @return \Illuminate\View\View
     */
    public function stokRendah()
    {
        $obat = Obat::where('stok', '<=', 10)
            ->paginate(10);

        return view('admin.obat.index', compact('obat'));
    }
}
