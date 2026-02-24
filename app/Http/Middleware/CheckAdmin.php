<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->exists('admin') || $request->session()->get('admin.role') != 'admin') {
            return redirect('/login-admin')->with('error', 'Silakan login sebagai admin terlebih dahulu!');
        }
        return $next($request);
    }
}
