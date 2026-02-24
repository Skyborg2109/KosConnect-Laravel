<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPemilik
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->exists('user') || $request->session()->get('user.role') != 'pemilik') {
            return redirect('/')->with('error', 'Silakan login sebagai pemilik terlebih dahulu!');
        }
        return $next($request);
    }
}
