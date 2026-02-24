<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  Role yang diizinkan (admin, pemilik, penyewa)
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login
        if (!$request->session()->has('role')) {
            // Redirect ke halaman login sesuai role yang diminta
            if ($role === 'admin') {
                return redirect('/login-admin')->with('error', 'Silakan login sebagai admin terlebih dahulu!');
            }
            return redirect('/')->with('error', 'Silakan login terlebih dahulu!');
        }

        // Cek apakah role user sesuai dengan role yang diminta
        if ($request->session()->get('role') !== $role) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini!');
        }

        return $next($request);
    }
}
