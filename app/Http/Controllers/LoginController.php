<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\LoginModel;

class LoginController extends Controller
{
    public function masuk (Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
        ]);

        $userByEmail = LoginModel::where('email', $request->email)->first();
        $user = LoginModel::where('email', $request->email)->where('role', $request->role)->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            // Authentication passed
            // Set the auth session - example: Laravel standard
            \Illuminate\Support\Facades\Auth::loginUsingId($user->id);
            
            // Simpan data ke session dalam bentuk array
            Session::put('user', [
                'login' => true,
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->nama_user,
                'role' => $user->role,
                'foto_profil' => $user->foto_profil,
                'login_time' => now(),
            ]);

            // Simpan role langsung untuk middleware CekRole
            Session::put('role', $user->role);



            if ($request->role == 'penyewa') {
                return redirect('/dashboard-penyewa');
            } elseif ($request->role == 'pemilik') {
                return redirect('/dashboard-pemilik');
            } else {
                return redirect('/'); // fallback
            }
        } else {
            // Authentication failed - provide specific error messages
            // Check which credential is wrong
            if (!$userByEmail) {
                // Email tidak ditemukan
                return back()
                    ->withErrors(['email_not_found' => 'Email tidak ditemukan.'])
                    ->withInput();
            } elseif ($userByEmail->role == 'admin') {
                // Email ada tapi role admin (tidak boleh login di sini)
                return back()
                    ->with('error', 'Anda tidak memiliki akses! Akun admin harus login di halaman login admin.')
                    ->withInput();
            } elseif (!$user) {
                // Role tidak sesuai dengan email
                return back()
                    ->withErrors(['role_not_match' => 'Role yang anda pilih tidak sesuai dengan email ini.'])
                    ->withInput()
                    ->with('password_value', $request->password); // Keep password in session
            } else {
                // Password salah
                return back()
                    ->withErrors(['password_wrong' => 'Password yang anda masukkan salah.'])
                    ->withInput();
            }
        }
    }

    public function masukAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $userByEmail = LoginModel::where('email', $request->email)->first();
        $user = LoginModel::where('email', $request->email)->where('role', 'admin')->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication passed
            // Simpan data admin ke session dalam bentuk array
            Session::put('admin', [
                'login' => true,
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->nama_user,
                'role' => 'admin',
                'foto_profil' => $user->foto_profil,
                'login_time' => now(),
            ]);

            // Simpan role langsung untuk middleware CekRole
            Session::put('role', 'admin');
            
            return redirect('/dashboard-admin');
        } else {
            // Authentication failed - provide specific error messages
            if (!$userByEmail) {
                // Email tidak ditemukan
                return back()->with('error', 'Email tidak ditemukan.');
            } elseif (!$user) {
                // Email ada tapi bukan admin
                return back()->with('error', 'Anda tidak memiliki akses! Akun ini bukan akun admin.');
            } else {
                // Password salah
                return back()->with('error', 'Password yang anda masukkan salah.');
            }
        }
    }
}
