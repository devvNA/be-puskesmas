<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Jika user sudah login, redirect ke dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Menggunakan email sebagai username untuk autentikasi
        $loginData = [
            'email'    => $credentials['username'],
            'password' => $credentials['password'],
        ];

        if (Auth::attempt($loginData, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Dapatkan user yang sudah login
            $user = Auth::user();

            // Log aktivitas login
            \Illuminate\Support\Facades\Log::info('User berhasil login', [
                'id'    => $user->id,
                'email' => $user->email,
                'name'  => $user->name,
                'role'  => $user->role,
            ]);

            // Default redirect ke dashboard admin
            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
    }

    /**
     * Proses logout user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register(Request $request)
    {
        // Implementasi register
    }

    public function store(Request $request)
    {
        // Implementasi store
    }

    public function show(Pasien $pasien)
    {
        // Implementasi show
    }

    public function edit(Pasien $pasien)
    {
        // Implementasi edit
    }

    public function update(Request $request, Pasien $pasien)
    {
        // Implementasi update
    }

    public function destroy(Pasien $pasien)
    {
        // Implementasi destroy
    }
}
