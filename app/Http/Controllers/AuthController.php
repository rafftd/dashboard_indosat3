<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = [
            'name' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Check if user must change password
            if (Auth::user()->must_change_password) {
                return redirect()->route('password.change')
                    ->with('warning', 'Anda harus mengubah password default sebelum melanjutkan.');
            }
            
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Login berhasil! Selamat datang ' . Auth::user()->getRoleDisplayName());
        }

        return back()->withErrors([
            'username' => 'Username atau password tidak sesuai.',
        ])->withInput($request->only('username'));
    }

    /**
     * Show dashboard
     */
    public function dashboard()
    {
        // Redirect Administrasi to purchase order index
        if (Auth::user()->isAdministrasi()) {
            return redirect()->route('purchase-orders.index');
        }
        
        // Redirect Designer to designer dashboard
        if (Auth::user()->isDesigner()) {
            return redirect()->route('designer.index');
        }
        
        // Redirect Markom Branch to POSM requests index
        if (Auth::user()->isMarkomBranch()) {
            return redirect()->route('posm-requests.index');
        }
        
        return view('dashboard');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}

