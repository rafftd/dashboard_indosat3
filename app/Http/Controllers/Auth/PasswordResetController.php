<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        $isAdmin = Auth::user()->role === User::ROLE_ADMINISTRASI || Auth::user()->role === 'admin';
        $users = [];
        
        if ($isAdmin) {
            // Admin bisa mengubah password sendiri atau user lain
            $users = User::orderBy('role')
                ->orderBy('name')
                ->get(['id', 'name', 'email', 'role']);
        }
        
        return view('auth.change-password', compact('isAdmin', 'users'));
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $currentUser = Auth::user();
        $isAdmin = $currentUser->role === User::ROLE_ADMINISTRASI || $currentUser->role === 'admin';
        
        // Validation rules berbeda untuk admin dan user biasa
        if ($isAdmin && $request->has('user_id')) {
            $userId = $request->user_id;
            
            // Cek apakah admin mengubah password sendiri atau user lain
            if ($userId == $currentUser->id) {
                // Admin mengubah password sendiri
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'current_password' => 'required',
                    'password' => 'required|min:6|confirmed',
                ]);
                
                // Verify current password
                if (!Hash::check($request->current_password, $currentUser->password)) {
                    return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
                }
                
                // Update password sendiri
                $currentUser->password = Hash::make($request->password);
                $currentUser->must_change_password = false;
                $currentUser->save();
                
                return back()->with('success', 'Password Anda berhasil diubah!');
            } else {
                // Admin mengubah password user lain
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'password' => 'required|min:6|confirmed',
                ]);
                
                $user = User::findOrFail($userId);
                
                // Update password user yang dipilih
                $user->password = Hash::make($request->password);
                $user->must_change_password = false;
                $user->save();
                
                return back()->with('success', "Password untuk {$user->name} berhasil diubah!");
            }
        } else {
            // User biasa mengubah password sendiri
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:6|confirmed',
            ]);

            // Verify current password
            if (!Hash::check($request->current_password, $currentUser->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }

            // Update password
            $currentUser->password = Hash::make($request->password);
            $currentUser->must_change_password = false;
            $currentUser->save();

            return redirect()->route('dashboard')->with('success', 'Password berhasil diubah!');
        }
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Reset password to default
     */
    public function resetToDefault(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        
        // Reset to default password "password"
        $user->password = Hash::make('password');
        $user->must_change_password = true;
        $user->save();

        return back()->with('success', 'Password telah direset ke default. Silakan login dengan password: "password" dan ubah password Anda.');
    }
}
