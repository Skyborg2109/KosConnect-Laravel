<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\data_user_model;
use App\Models\OtpVerification;
use App\Services\EmailService;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function daftarLagi(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|min:3|max:50',
            'email' => 'required|email|unique:data_user,email',
            'password' => 'required|min:6',
            'role' => 'required|in:penyewa,pemilik',
        ], [
            'nama_user.required' => 'Nama wajib diisi',
            'nama_user.min' => 'Nama minimal 3 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'role.required' => 'Role wajib dipilih',
        ]);

        // Check if username already exists
        $userExists = data_user_model::where('nama_user', $request->nama_user)->first();

        if ($userExists) {
            return back()->withErrors(['nama_user' => 'Username sudah digunakan'])->withInput();
        }

        // Generate 6-digit OTP and Token
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $token = \Illuminate\Support\Str::random(60);
        $expiresAt = now()->addMinutes(10);

        try {
            // Save OTP to database
            OtpVerification::create([
                'email' => $request->email,
                'otp_code' => $otpCode,
                'token' => $token,
                'expires_at' => $expiresAt,
                'verified' => false,
            ]);

            // Send OTP email
            $emailSent = $this->emailService->sendOTP($request->email, $otpCode, $request->nama_user, $token);

            if (!$emailSent) {
                return back()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi.')->withInput();
            }

            // Store registration data in session (temporary)
            session([
                'pending_registration' => [
                    'nama_user' => $request->nama_user,
                    'email' => $request->email,
                    'password' => $request->password, // Will be hashed when creating user
                    'role' => $request->role,
                    'otp_expires_at' => $expiresAt->toIso8601String(),
                ]
            ]);

            return redirect('/verify-otp')->with('success', 'Kode OTP telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');

        } catch (\Exception $e) {
            \Log::error('Registration OTP error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.')->withInput();
        }
    }
}
