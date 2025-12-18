<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:users,name',
                'role' => 'required|in:administrasi,designer,markom_regional,markom_branch,vendor',
                'password' => ['required', 'confirmed', 'min:6'],
            ], [
                'name.required' => 'Username wajib diisi',
                'name.unique' => 'Username sudah terdaftar',
                'role.required' => 'Role wajib dipilih',
                'password.required' => 'Password wajib diisi',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'password.min' => 'Password minimal 6 karakter',
            ]);

            // Generate email from username
            $email = strtolower(str_replace(' ', '_', $validated['name'])) . '@indosat.com';
            
            $user = User::create([
                'name' => $validated['name'],
                'email' => $email,
                'role' => $validated['role'],
                'password' => Hash::make($validated['password']),
                'must_change_password' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dibuat',
                'data' => $user
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
