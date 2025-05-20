<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil user
     */
    public function show(Request $request)
    {
        $user   = $request->user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        if (! $pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'user'   => $user,
                'pasien' => $pasien,
            ],
        ]);
    }

    /**
     * Mengupdate profil user
     */
    public function update(Request $request)
    {
        $user   = $request->user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        if (! $pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'alamat'   => 'required|string',
            'no_hp'    => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Update user
        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update pasien
        $pasien->nama   = $request->name;
        $pasien->alamat = $request->alamat;
        $pasien->no_hp  = $request->no_hp;
        $pasien->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data'    => [
                'user'   => $user,
                'pasien' => $pasien,
            ],
        ]);
    }

    /**
     * Upload foto profil
     */
    public function uploadPhoto(Request $request)
    {
        $user   = $request->user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        if (! $pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Hapus foto lama jika ada
        if ($pasien->foto && Storage::exists('public/pasien/' . $pasien->foto)) {
            Storage::delete('public/pasien/' . $pasien->foto);
        }

        // Upload foto baru
        $photoName = time() . '_' . $pasien->id . '.' . $request->photo->extension();
        $request->photo->storeAs('public/pasien', $photoName);

        // Simpan nama file foto
        $pasien->foto = $photoName;
        $pasien->save();

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diperbarui',
            'data'    => [
                'foto'     => $photoName,
                'foto_url' => url('storage/pasien/' . $photoName),
            ],
        ]);
    }

    /**
     * Mendapatkan daftar anggota keluarga
     */
    public function getKeluarga(Request $request)
    {
        $user   = $request->user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        if (! $pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        $keluarga = Pasien::where('user_id', $user->id)
            ->where('id', '!=', $pasien->id)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $keluarga,
        ]);
    }

    /**
     * Menambah anggota keluarga
     */
    public function addKeluarga(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'nik'           => 'required|string|unique:pasien,nik',
            'nama'          => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'no_hp'         => 'required|string',
            'hubungan'      => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $keluarga = Pasien::create([
            'user_id'       => $user->id,
            'nik'           => $request->nik,
            'nama'          => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
            'no_hp'         => $request->no_hp,
            'hubungan'      => $request->hubungan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Anggota keluarga berhasil ditambahkan',
            'data'    => $keluarga,
        ], 201);
    }

    /**
     * Mengupdate anggota keluarga
     */
    public function updateKeluarga(Request $request, $id)
    {
        $user = $request->user();

        $keluarga = Pasien::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (! $keluarga) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota keluarga tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nik'           => 'required|string|unique:pasien,nik,' . $keluarga->id,
            'nama'          => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'no_hp'         => 'required|string',
            'hubungan'      => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $keluarga->update([
            'nik'           => $request->nik,
            'nama'          => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
            'no_hp'         => $request->no_hp,
            'hubungan'      => $request->hubungan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Anggota keluarga berhasil diperbarui',
            'data'    => $keluarga,
        ]);
    }

    /**
     * Menghapus anggota keluarga
     */
    public function deleteKeluarga(Request $request, $id)
    {
        $user = $request->user();

        $keluarga = Pasien::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (! $keluarga) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota keluarga tidak ditemukan',
            ], 404);
        }

        // Cek apakah ada pendaftaran terkait
        $pendaftaran = Pendaftaran::where('pasien_id', $keluarga->id)->count();

        if ($pendaftaran > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus anggota keluarga yang memiliki riwayat pendaftaran',
            ], 422);
        }

        $keluarga->delete();

        return response()->json([
            'success' => true,
            'message' => 'Anggota keluarga berhasil dihapus',
        ]);
    }

    /**
     * Menampilkan riwayat kunjungan
     */
    public function riwayatKunjungan(Request $request)
    {
        $user      = $request->user();
        $pasienIds = Pasien::where('user_id', $user->id)->pluck('id');

        if ($pasienIds->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data pasien tidak ditemukan',
            ], 404);
        }

        // Filter berdasarkan pasien_id jika ada
        $query = Pendaftaran::with(['dokter', 'dokter.poli', 'pasien'])
            ->whereIn('pasien_id', $pasienIds)
            ->orderBy('created_at', 'desc');

        if ($request->has('pasien_id')) {
            $query->where('pasien_id', $request->pasien_id);
        }

        $riwayat = $query->get();

        return response()->json([
            'success' => true,
            'data'    => $riwayat,
        ]);
    }
}
