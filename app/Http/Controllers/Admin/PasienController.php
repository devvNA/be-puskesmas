<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'email'         => 'nullable|email|unique:pasien,email',
            'no_rm'         => 'nullable|string|max:20|unique:pasien,no_rm',
            'nik'           => 'required|string|size:16|unique:pasien,nik',
            'no_bpjs'       => 'nullable|string|unique:pasien,no_bpjs',
            'jenis'         => 'required|in:Reguler (BPJS),Eksekutif (Non BPJS)',
            'hubungan_keluarga' => 'nullable|string',
            'nama'          => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'golongan_darah' => 'nullable|in:A,B,AB,O,-',
            'alamat'        => 'required|string',
            'rt'            => 'nullable|string',
            'rw'            => 'nullable|string',
            'provinsi'      => 'nullable|string',
            'no_telepon'    => 'nullable|string|max:15|unique:pasien,no_telepon',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['_token', 'foto']);

        // Generate nomor RM baru jika tidak ada
        if (empty($data['no_rm'])) {
            $data['no_rm'] = 'RM-' . str_pad(Pasien::count() + 1, 3, '0', STR_PAD_LEFT);
        }

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $path = $foto->store('pasien', 'public');
            $data['foto'] = $path;
        }

        // Buat user jika email diisi
        if (!empty($data['email'])) {
            $user = User::create([
                'name'     => $data['nama'],
                'email'    => $data['email'],
                'no_telepon' => $data['no_telepon'],
                'password' => Hash::make(Str::random(10)), // Password acak yang nanti bisa direset
                'role'     => 'pasien',
            ]);

            $data['user_id'] = $user->id;
        }

        Pasien::create($data);

        return redirect()->route('admin.pasien.index');
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
        $pasien->load(['pendaftaran', 'rekamMedis', 'user']);

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
            'email'         => 'nullable|email|unique:pasien,email,' . $pasien->id,
            'no_rm'         => 'nullable|string|max:20|unique:pasien,no_rm,' . $pasien->id,
            'nik'           => 'required|string|size:16|unique:pasien,nik,' . $pasien->id,
            'no_bpjs'       => 'nullable|string|unique:pasien,no_bpjs,' . $pasien->id,
            'jenis'         => 'required|in:Reguler (BPJS),Eksekutif (Non BPJS)',
            'hubungan_keluarga' => 'nullable|string',
            'nama'          => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'golongan_darah' => 'nullable|in:A,B,AB,O,-',
            'alamat'        => 'required|string',
            'rt'            => 'nullable|string',
            'rw'            => 'nullable|string',
            'provinsi'      => 'nullable|string',
            'no_telepon'    => 'nullable|string|max:15|unique:pasien,no_telepon,' . $pasien->id,
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'foto']);

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pasien->foto) {
                Storage::disk('public')->delete($pasien->foto);
            }

            $foto = $request->file('foto');
            $path = $foto->store('pasien', 'public');
            $data['foto'] = $path;
        }

        // Update user jika ada
        if ($pasien->user_id) {
            $user = User::find($pasien->user_id);
            if ($user) {
                $user->name = $data['nama'];
                if (!empty($data['email'])) {
                    $user->email = $data['email'];
                }
                if (!empty($data['no_telepon'])) {
                    $user->no_telepon = $data['no_telepon'];
                }
                $user->save();
            }
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

        // Hapus user terkait jika ada
        if ($pasien->user_id) {
            $user = User::find($pasien->user_id);
            if ($user) {
                $user->delete();
            }
        }

        $pasien->delete();

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil dihapus');
    }

    /**
     * Mencari data pasien berdasarkan nama, no RM, atau NIK
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
            ->orWhere('no_bpjs', 'like', "%{$search}%")
            ->orWhere('no_telepon', 'like', "%{$search}%")
            ->latest()
            ->paginate(10);

        return view('admin.pasien.index', compact('pasien', 'search'));
    }
}
