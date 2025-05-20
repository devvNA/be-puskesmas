<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PinController extends Controller
{
    /**
     * Membuat PIN baru untuk user yang telah login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|string|size:6|regex:/^[0-9]+$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // Update PIN user
        $user->pin = Hash::make($request->pin);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'PIN berhasil dibuat',
        ]);
    }

    /**
     * Verifikasi PIN user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|string|size:6|regex:/^[0-9]+$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!$user->pin) {
            return response()->json([
                'success' => false,
                'message' => 'PIN belum dibuat'
            ], 400);
        }

        if (!Hash::check($request->pin, $user->pin)) {
            return response()->json([
                'success' => false,
                'message' => 'PIN tidak valid'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'PIN valid'
        ]);
    }

    /**
     * Mengubah PIN user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_pin' => 'required|string|size:6|regex:/^[0-9]+$/',
            'new_pin' => 'required|string|size:6|regex:/^[0-9]+$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!$user->pin) {
            return response()->json([
                'success' => false,
                'message' => 'PIN belum dibuat'
            ], 400);
        }

        if (!Hash::check($request->current_pin, $user->pin)) {
            return response()->json([
                'success' => false,
                'message' => 'PIN saat ini tidak valid'
            ], 401);
        }

        // Update PIN user
        $user->pin = Hash::make($request->new_pin);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'PIN berhasil diubah'
        ]);
    }

    /**
     * Menghapus PIN user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pin' => 'required|string|size:6|regex:/^[0-9]+$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!$user->pin) {
            return response()->json([
                'success' => false,
                'message' => 'PIN belum dibuat'
            ], 400);
        }

        if (!Hash::check($request->pin, $user->pin)) {
            return response()->json([
                'success' => false,
                'message' => 'PIN tidak valid'
            ], 401);
        }

        // Hapus PIN user
        $user->pin = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'PIN berhasil dihapus'
        ]);
    }
}
