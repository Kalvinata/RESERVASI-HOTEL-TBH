<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Register
    public function showRegister()
    {
        return view('auth.register'); // Sesuaikan dengan nama folder view register kamu
    }

    // 2. Memproses Data Register
  // Memproses Data Login
    public function loginPost(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba cocokkan email dan password dengan database
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Keamanan session

            // 3. Cek Role (Hak Akses) dan arahkan ke dashboard masing-masing
            $role = Auth::user()->role;
            
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'front_office') {
                return redirect()->intended('/fo/dashboard');
            } elseif ($role === 'housekeeping') {
                return redirect()->intended('/hk/dashboard');
            } else {
                // Default untuk guest/tamu
                return redirect()->intended('/guest');
            }
        }

        // 4. Jika gagal login, kembalikan ke halaman login bawa pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email'); // Biarkan email tetap terisi
    }

    // Fungsi untuk Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}