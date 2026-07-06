<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan Halaman Login (INI YANG TADI SEMPAT HILANG)
    public function showLogin()
    {
        return view('auth.login'); 
    }

    // 2. Menampilkan Halaman Register
    public function showRegister()
    {
        return view('auth.register'); 
    }

    // 3. Memproses Data Register
    public function registerPost(Request $request)
    {
        // Validasi data yang diisi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.min' => 'Password minimal harus 8 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak cocok!',
            'email.unique' => 'Email ini sudah terdaftar!',
            'phone.required' => 'Nomor WhatsApp wajib diisi!'
        ]);

        // Simpan ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password), 
            'role' => 'guest', // Otomatis menjadi akun tamu
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // 4. Memproses Data Login
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            
            if ($role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'front_office') {
                return redirect()->intended('/fo/dashboard');
            } elseif ($role === 'housekeeping') {
                return redirect()->intended('/hk/dashboard');
            } else {
                return redirect()->intended('/guest');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email'); 
    }

    // 5. Fungsi untuk Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}