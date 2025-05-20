<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    /**
     * Tambahkan rate limiting untuk mencegah serangan brute force
     */
    private function isRateLimited($key, $maxAttempts = 5)
    {
        $executed = RateLimiter::attempt(
            'auth:' . $key,
            $maxAttempts,
            function () {
                return true;
            },
            60 // 1 menit
        );

        if (!$executed) {
            return true; // Rate limited
        }

        return false;
    }

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'email'         => 'required_without:no_telepon|string|email|max:255|unique:users,email',
            'no_telepon'    => 'required_without:email|string|unique:pasien,no_telepon',
            'nik'           => 'required|string|unique:pasien,nik',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat'        => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate random password (pengguna tidak akan pernah menggunakan ini)
        $randomPassword = Str::random(12);

        // Gunakan email jika ada, jika tidak gunakan no_telepon dengan domain khusus
        $email = $request->email;
        if (!$email && $request->no_telepon) {
            // Buat email placeholder untuk pengguna tanpa email
            $email = $request->no_telepon . '@phone.user';
        }

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $email,
            'password' => Hash::make($randomPassword), // Password acak yang tidak akan digunakan
            'role'     => 'pasien',
        ]);

        // Buat data pasien baru terkait dengan user
        Pasien::create([
            'user_id'       => $user->id,
            'email'         => $request->email ?? null,
            'no_rm'         => $this->generateNoRM(),
            'nik'           => $request->nik,
            'nama'          => $request->name,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
            'no_telepon'    => $request->no_telepon ?? null,
        ]);

        // Generate token langsung setelah pendaftaran berhasil
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil',
            'user'    => $user,
            'token'   => $token,
            'has_pin' => false, // pengguna baru belum memiliki PIN
            'next_step' => 'create_pin' // menginformasikan client untuk membuat PIN
        ], 201);
    }

    //Generate No RM
    public function generateNoRM()
    {
        $no_rm = 'RM-' . str_pad(Pasien::count() + 1, 3, '0', STR_PAD_LEFT);
        return $no_rm;
    }

    /**
     * Login user with password (tetap disediakan sebagai fallback)
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (! Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah'],
            ]);
        }

        $user  = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Check if user has PIN
        $has_pin = !is_null($user->pin);

        return response()->json([
            'message' => 'Login berhasil',
            'user'    => $user,
            'token'   => $token,
            'has_pin' => $has_pin
        ]);
    }

    /**
     * Get authenticated user info
     */
    public function user(Request $request)
    {
        $user   = $request->user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        // Check if user has PIN
        $has_pin = !is_null($user->pin);

        return response()->json([
            'user'    => $user,
            'pasien'  => $pasien,
            'has_pin' => $has_pin
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil logout',
        ]);
    }

    /**
     * Login with PIN
     */
    public function loginWithPin(Request $request)
    {
        // Cek rate limiting berdasarkan IP address
        if ($this->isRateLimited($request->ip())) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak upaya login. Silakan coba lagi dalam beberapa menit.'
            ], 429);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required_without:no_telepon|email',
            'no_telepon' => 'required_without:email|string',
            'pin'   => 'required|string|size:6|regex:/^[0-9]+$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = null;

        if ($request->email) {
            $user = User::where('email', $request->email)->first();
        } else if ($request->no_telepon) {
            $pasien = Pasien::where('no_telepon', $request->no_telepon)->first();
            if ($pasien) {
                $user = User::find($pasien->user_id);
            }
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        if (!$user->pin) {
            return response()->json([
                'success' => false,
                'message' => 'PIN belum dibuat untuk pengguna ini'
            ], 400);
        }

        if (!Hash::check($request->pin, $user->pin)) {
            // Tambah counter rate limiting untuk IP ini
            RateLimiter::hit('auth:' . $request->ip());

            return response()->json([
                'success' => false,
                'message' => 'PIN tidak valid'
            ], 401);
        }

        // Login berhasil, buat token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login dengan PIN berhasil',
            'user'    => $user,
            'token'   => $token
        ]);
    }

    /**
     * Verify email untuk login tanpa password
     */
    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:no_telepon|email',
            'no_telepon' => 'required_without:email|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = null;
        $identifier = $request->email ?? $request->no_telepon;

        if ($request->email) {
            $user = User::where('email', $request->email)->first();
        } else if ($request->no_telepon) {
            $pasien = Pasien::where('no_telepon', $request->no_telepon)->first();
            if ($pasien) {
                $user = User::find($pasien->user_id);
            }
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        // Cek apakah user memiliki PIN
        $has_pin = !is_null($user->pin);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna ditemukan',
            'user_id' => $user->id,
            'name'    => $user->name,
            'has_pin' => $has_pin,
            'auth_methods' => [
                'pin' => $has_pin
            ]
        ]);
    }
}
