<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasienController extends Controller
{
    /**
     * Menyimpan pasien baru
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|unique:pasien,nik',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pasien,email',
            'no_telepon' => 'required|string|unique:pasien,no_telepon',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'golongan_darah' => 'required|in:A,B,AB,O,-A,-B,-AB,-O,A+,B+,AB+,O+',
            'hubungan_keluarga' => 'required|string',
            'alamat' => 'required|string',
            'rt' => 'required|string',
            'rw' => 'required|string',
            'provinsi' => 'required|string',
            'jenis_pasien' => 'required|in:Reguler (BPJS),Eksekutif (Non BPJS)',
            'no_bpjs' => 'nullable|string|unique:pasien,no_bpjs',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Buat user baru
        $user = User::create([
            'name'     => $request->input('nama'),
            'email'    => $request->input('email') ?? null,
            'no_telepon'    => $request->input('no_telepon') ?? null,
            'password' => Hash::make(Str::random(10)), // Password acak yang tidak akan digunakan
            'role'     => 'pasien',
        ]);

        //Generate No RM
        function generateNoRM()
        {
            $no_rm = 'RM-' . str_pad(Pasien::count() + 1, 3, '0', STR_PAD_LEFT);
            return $no_rm;
        }


        // Simpan data pasien
        $pasien = Pasien::create([
            'user_id' => $user->id,
            'email' => $request->input('email') ?? null,
            'no_rm' => generateNoRM(),
            'nik' => $request->input('nik'),
            'no_bpjs' => $request->input('no_bpjs'),
            'jenis' => $request->input('jenis_pasien'),
            'hubungan_keluarga' => $request->input('hubungan_keluarga'),
            'nama' => $request->input('nama') ?? null,
            'tanggal_lahir' => $request->input('tanggal_lahir') ?? null,
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'golongan_darah' => $request->input('golongan_darah'),
            'alamat' => $request->input('alamat'),
            'rt' => $request->input('rt'),
            'rw' => $request->input('rw'),
            'provinsi' => $request->input('provinsi'),
            'no_telepon' => $request->input('no_telepon'),
        ]);


        // return response()->json([
        //     'success' => true,
        //     'message' => 'Data pasien berhasil disimpan',
        //     'user' => $user,
        //     'data' => $pasien
        // ], 201);

        return response()->json([
            'success' => true,
            'message' => 'Data pasien berhasil disimpan',
            'data'    => [
                'user'   => $user,
                'pasien' => $pasien,
            ],
        ], 201);
    }



    /**
     * Menampilkan detail pasien
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $pasien = Pasien::find($id);

        if (!$pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan'
            ], 404);
        }

        // Hanya admin atau pemilik data yang dapat mengakses
        if ($pasien->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak memiliki akses'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $pasien
        ]);
    }

    /**
     * Update data pasien
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $pasien = Pasien::find($id);

        if (!$pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan'
            ], 404);
        }

        // Hanya admin atau pemilik data yang dapat mengubah
        if ($user->role !== 'admin' && $pasien->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak memiliki akses'
            ], 403);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email|unique:pasien,email,' . $id,
            'nik' => 'required|string|unique:pasien,nik,' . $id,
            'no_bpjs' => 'nullable|string|unique:pasien,no_bpjs,' . $id,
            'jenis' => 'required|in:Utama,Keluarga',
            'hubungan_keluarga' => 'required_if:jenis,Keluarga|string',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'golongan_darah' => 'nullable|in:A,B,AB,O,-A,-B,-AB,-O,A+,B+,AB+,O+',
            'alamat' => 'required|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kabupaten' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'no_telepon' => 'nullable|string|unique:pasien,no_telepon,' . $id,
            'agama' => 'nullable|string',
            'status_pernikahan' => 'nullable|string',
            'pekerjaan' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Upload foto baru jika ada
        $fotoPath = $pasien->foto;
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pasien->foto && Storage::exists('public/' . $pasien->foto)) {
                Storage::delete('public/' . $pasien->foto);
            }

            $fotoPath = $request->file('foto')->store('public/pasien');
            $fotoPath = str_replace('public/', '', $fotoPath);
        }

        // Update data pasien
        $pasien->update([
            'email' => $request->input('email', $pasien->email),
            'nik' => $request->input('nik'),
            'no_bpjs' => $request->input('no_bpjs'),
            'jenis' => $request->input('jenis'),
            'hubungan_keluarga' => $request->input('hubungan_keluarga'),
            'nama' => $request->input('nama'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'golongan_darah' => $request->input('golongan_darah'),
            'alamat' => $request->input('alamat'),
            'rt' => $request->input('rt'),
            'rw' => $request->input('rw'),
            'kelurahan' => $request->input('kelurahan'),
            'kecamatan' => $request->input('kecamatan'),
            'kabupaten' => $request->input('kabupaten'),
            'provinsi' => $request->input('provinsi'),
            'no_telepon' => $request->input('no_telepon'),
            'agama' => $request->input('agama'),
            'status_pernikahan' => $request->input('status_pernikahan'),
            'pekerjaan' => $request->input('pekerjaan'),
            'foto' => $fotoPath,
        ]);

        // Update nama user jika ini pasien utama
        if ($pasien->user_id && $pasien->jenis === 'Utama') {
            $user = User::find($pasien->user_id);
            if ($user) {
                $user->name = $request->input('nama');
                $user->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pasien berhasil diperbarui',
            'data' => $pasien
        ]);
    }

    /**
     * Hapus data pasien
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        // Hanya admin yang dapat menghapus data pasien
        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak memiliki akses'
            ], 403);
        }

        $pasien = Pasien::find($id);

        if (!$pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan'
            ], 404);
        }

        // Hapus foto jika ada
        if ($pasien->foto && Storage::exists('public/' . $pasien->foto)) {
            Storage::delete('public/' . $pasien->foto);
        }

        // Hapus user terkait jika ini pasien utama
        if ($pasien->user_id && $pasien->jenis === 'Utama') {
            $user = User::find($pasien->user_id);
            if ($user) {
                $user->delete();
            }
        }

        $pasien->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pasien berhasil dihapus'
        ]);
    }

    /**
     * Upload foto pasien
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFoto(Request $request, $id)
    {
        $user = $request->user();
        $pasien = Pasien::find($id);

        if (!$pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan'
            ], 404);
        }

        // Hanya admin atau pemilik data yang dapat mengubah
        if ($user->role !== 'admin' && $pasien->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak memiliki akses'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Hapus foto lama jika ada
        if ($pasien->foto && Storage::exists('public/' . $pasien->foto)) {
            Storage::delete('public/' . $pasien->foto);
        }

        // Upload foto baru
        $fotoPath = $request->file('foto')->store('public/pasien');
        $fotoPath = str_replace('public/', '', $fotoPath);

        // Update data pasien
        $pasien->foto = $fotoPath;
        $pasien->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diupload',
            'data' => $pasien
        ]);
    }

    /**
     * Mendapatkan data keluarga dari pasien utama
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKeluarga(Request $request)
    {
        $user = $request->user();

        // Cari pasien utama
        $pasienUtama = Pasien::where('user_id', $user->id)
            ->where('jenis', 'Utama')
            ->first();

        if (!$pasienUtama) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien utama tidak ditemukan'
            ], 404);
        }

        // Cari anggota keluarga (dengan NIK yang sama pada kolom tertentu atau identifier lain)
        $keluarga = Pasien::where('nik', $pasienUtama->nik)
            ->where('jenis', 'Keluarga')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'pasien_utama' => $pasienUtama,
                'anggota_keluarga' => $keluarga
            ]
        ]);
    }
    /**
     * Mendapatkan data pasien berdasarkan nomor rekam medis
     *
     * @param  string  $noRm
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPasien($noRm)
    {
        // Cari pasien berdasarkan nomor rekam medis
        $pasien = Pasien::where('no_rm', $noRm)->first();

        if (!$pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien dengan nomor rekam medis tersebut tidak ditemukan'
            ], 404);
        }

        // Dapatkan data user terkait jika ada
        $user = null;
        if ($pasien->user_id) {
            $user = User::find($pasien->user_id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pasien berhasil ditemukan',
            'data' => [
                'pasien' => $pasien,
                'user' => $user
            ]
        ]);
    }
}
