<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPenyewa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->exists('user') || $request->session()->get('user.role') != 'penyewa') {
            return redirect('/')->with('error', 'Silakan login sebagai penyewa terlebih dahulu!');
        }
        return $next($request);
    }
}
