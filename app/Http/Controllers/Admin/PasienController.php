<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PasienController extends Controller
{
    /**
     * Menampilkan daftar pasien
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pasien = Pasien::latest()->paginate(10);
        return view('admin.pasien.index', compact('pasien'));
    }

    /**
     * Menampilkan form untuk membuat pasien baru
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.pasien.create');
    }

    /**
     * Menyimpan data pasien baru
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'         => 'required|email|unique:pasien,email',
            'no_rm'         => 'required|string|max:20|unique:pasien,no_rm',
            'nik'           => 'required|string|size:16|unique:pasien,nik',
            'nama'          => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'required|string',
            'no_telepon'    => 'required|string|max:15',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $foto         = $request->file('foto');
            $path         = $foto->store('pasien', 'public');
            $data['foto'] = $path;
        }

        Pasien::create($data);

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan');
    }

    /**
     * Menampilkan detail pasien
     *
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\View\View
     */
    public function show(Pasien $pasien)
    {
        // Memuat data pendaftaran dan rekam medis
        $pasien->load(['pendaftaran', 'rekamMedis']);

        return view('admin.pasien.show', compact('pasien'));
    }

    /**
     * Menampilkan form untuk mengedit pasien
     *
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\View\View
     */
    public function edit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    /**
     * Menyimpan perubahan data pasien
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'no_rm'         => 'nullable|string|max:20|unique:pasien,no_rm,' . $pasien->id,
            'nik'           => 'required|string|size:16|unique:pasien,nik,' . $pasien->id,
            'email'         => 'required|email|unique:pasien,email,' . $pasien->id,
            'nama'          => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'required|string',
            'no_telepon'    => 'required|string|max:15',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pasien->foto) {
                Storage::disk('public')->delete($pasien->foto);
            }

            $foto         = $request->file('foto');
            $path         = $foto->store('pasien', 'public');
            $data['foto'] = $path;
        }

        $pasien->update($data);

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui');
    }

    /**
     * Menghapus data pasien
     *
     * @param  \App\Models\Pasien  $pasien
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pasien $pasien)
    {
        // Periksa apakah pasien memiliki pendaftaran atau rekam medis
        if ($pasien->pendaftaran()->count() > 0 || $pasien->rekamMedis()->count() > 0) {
            return redirect()->route('admin.pasien.index')
                ->with('error', 'Pasien tidak dapat dihapus karena masih memiliki data pendaftaran atau rekam medis terkait');
        }

        // Hapus foto jika ada
        if ($pasien->foto) {
            Storage::disk('public')->delete($pasien->foto);
        }

        $pasien->delete();

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil dihapus');
    }

    /**
     * Mencari data pasien berdasarkan nama atau no RM
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $search = $request->get('search');

        $pasien = Pasien::where('nama', 'like', "%{$search}%")
            ->orWhere('no_rm', 'like', "%{$search}%")
            ->orWhere('nik', 'like', "%{$search}%")
            ->latest()
            ->paginate(10);

        return view('admin.pasien.index', compact('pasien', 'search'));
    }
}
