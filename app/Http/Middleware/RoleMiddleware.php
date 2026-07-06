<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Jika belum login, arahkan ke halaman login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Jika Role sesuai, izinkan masuk
        $userRole = Auth::user()->role;
        if ($userRole === $role) {
            return $next($request);
        }

        // Jika Role TIDAK sesuai, kembalikan ke dashboard masing-masing
        if ($userRole === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($userRole === 'front_office') {
            return redirect('/fo/dashboard');
        } elseif ($userRole === 'housekeeping') {
            return redirect('/hk/dashboard');
        } else {
            return redirect('/guest');
        }
    }
}