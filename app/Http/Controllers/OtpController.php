<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtpVerification;
use App\Models\data_user_model;
use App\Services\EmailService;
use Illuminate\Support\Facades\Hash;

class OtpController extends Controller
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Show OTP verification form
     */
    public function showVerificationForm()
    {
        // Check if there's pending registration data in session
        if (!session()->has('pending_registration')) {
            return redirect('/login')->with('error', 'Sesi verifikasi tidak ditemukan. Silakan daftar ulang.');
        }

        $email = session('pending_registration.email');
        $expiresAt = session('pending_registration.otp_expires_at');

        return view('auth.verify-otp', compact('email', 'expiresAt'));
    }

    /**
     * Verify OTP code
     */
    /**
     * Verify OTP code
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ], [
            'otp_code.required' => 'Kode OTP wajib diisi',
            'otp_code.size' => 'Kode OTP harus 6 digit',
        ]);

        if (!session()->has('pending_registration')) {
            return redirect('/login')->with('error', 'Sesi verifikasi tidak ditemukan. Silakan daftar ulang.');
        }

        $email = session('pending_registration.email');
        $otpCode = $request->otp_code;

        // Find the latest OTP for this email
        $otpRecord = OtpVerification::where('email', $email)
            ->where('verified', false)
            ->latest()
            ->first();

        if (!$otpRecord) {
            return back()->with('error', 'Kode OTP tidak ditemukan. Silakan minta kode baru.');
        }

        // Check if OTP is valid
        if (!$otpRecord->isValid($otpCode)) {
            if ($otpRecord->isExpired()) {
                return back()->with('error', 'Kode OTP telah kadaluarsa. Silakan minta kode baru.');
            }
            return back()->with('error', 'Kode OTP tidak valid. Silakan periksa kembali.');
        }

        // Mark OTP as verified
        $otpRecord->update(['verified' => true]);

        // Create user account
        return $this->createUserAndRedirect(session('pending_registration'));
    }

    /**
     * Verify Activation Link
     */
    public function verifyLink($token)
    {
        $otpRecord = OtpVerification::where('token', $token)
            ->where('verified', false)
            ->first();

        if (!$otpRecord) {
            return redirect('/login')->with('error', 'Link aktivasi tidak valid atau sudah digunakan.');
        }

        if ($otpRecord->isExpired()) {
            return redirect('/login')->with('error', 'Link aktivasi telah kadaluarsa. Silakan daftar ulang.');
        }

        // Mark as verified
        $otpRecord->update(['verified' => true]);

        // Since we don't have session data for link verification (could be different browser),
        // we can't strictly use pending_registration from session.
        // However, assuming the flow started recently, we might check session or
        // relying on re-registration if session is lost is safer but annoying.
        
        // BETTER APPROACH: Since we have the email in OTP record, 
        // we ideally should have stored the temp user data in DB or just use session if available.
        // For now, let's rely on session being present as per typical flow, 
        // OR ask user to re-register if session is lost (limitation of stateless registration).
        
        if (!session()->has('pending_registration') || session('pending_registration.email') !== $otpRecord->email) {
             return redirect('/login')->with('error', 'Sesi pendaftaran telah berakhir. Silakan lakukan pendaftaran ulang.');
        }

        return $this->createUserAndRedirect(session('pending_registration'));
    }

    /**
     * Create user and redirect to login
     */
    private function createUserAndRedirect($registrationData)
    {
        try {
            data_user_model::create([
                'nama_user' => $registrationData['nama_user'],
                'email' => $registrationData['email'],
                'password' => Hash::make($registrationData['password']),
                'role' => $registrationData['role'],
                'nomor_telepon' => null,
                'alamat' => null,
                'tanggal_lahir' => null,
                'jenis_kelamin' => null,
                'foto_profil' => null,
            ]);

            // Clear pending registration data
            session()->forget('pending_registration');

            return redirect('/login')->with('success', 'Akun berhasil diaktifkan! Silakan login.');

        } catch (\Exception $e) {
            \Log::error('User creation error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Terjadi kesalahan saat membuat akun. Silakan coba lagi.');
        }
    }

    /**
     * Resend OTP code
     */
    public function resendOtp(Request $request)
    {
        if (!session()->has('pending_registration')) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi verifikasi tidak ditemukan.'
            ], 400);
        }

        $registrationData = session('pending_registration');
        $email = $registrationData['email'];

        // Generate new OTP and Token
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $token = \Illuminate\Support\Str::random(60);
        $expiresAt = now()->addMinutes(10);

        // Save OTP to database
        OtpVerification::create([
            'email' => $email,
            'otp_code' => $otpCode,
            'token' => $token,
            'expires_at' => $expiresAt,
            'verified' => false,
        ]);

        // Send OTP email
        $emailSent = $this->emailService->sendOTP($email, $otpCode, $registrationData['nama_user'], $token);

        if ($emailSent) {
            // Update session with new expiry time
            session(['pending_registration.otp_expires_at' => $expiresAt->toIso8601String()]);

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP dan link aktivasi baru telah dikirim ke email Anda.',
                'expires_at' => $expiresAt->toIso8601String(),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengirim email. Silakan coba lagi.'
        ], 500);
    }
}
