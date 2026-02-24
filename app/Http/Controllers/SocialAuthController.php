<?php

namespace App\Http\Controllers;

use App\Models\data_user_model;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        // Enforce session start before redirect to ensure cookie is set
        session()->put('oauth_init', true);
        session()->save();
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            // Use stateless to avoid InvalidStateException on session mismatch (common in dev)
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Find user by Google ID or email
            $user = data_user_model::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            $isNewUser = false;

            if ($user) {
                // Update Google ID if not set, and update photo if missing
                $updateData = [];
                if (!$user->google_id) {
                    $updateData['google_id'] = $googleUser->getId();
                }
                if (!$user->foto_profil || !$user->avatar) {
                    $updateData['avatar'] = $googleUser->getAvatar();
                    $updateData['foto_profil'] = $user->foto_profil ?? $googleUser->getAvatar();
                }
                
                if (!empty($updateData)) {
                    $user->update($updateData);
                }
            } else {
                // Create new user
                $isNewUser = true;
                $user = data_user_model::create([
                    'nama_user' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(Str::random(16)), // Random password
                    'role' => 'penyewa', // Default role
                    'nomor_telepon' => null,
                    'alamat' => null,
                    'tanggal_lahir' => null,
                    'jenis_kelamin' => null,
                    'foto_profil' => $googleUser->getAvatar(),
                ]);
            }

            // Log the user in
            $this->loginUser($user);

            if ($isNewUser) {
                return redirect()->route('google.confirm');
            }

            return redirect($this->getDashboardRoute($user->role));

        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            // Log full trace to a dedicated file for debugging
            $logMessage = date('Y-m-d H:i:s') . " - Google Error: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
            file_put_contents(storage_path('logs/oauth_debug.log'), $logMessage, FILE_APPEND);
            
            $errorMessage = 'Gagal login dengan Google. ';
            if (str_contains($e->getMessage(), 'Could not find a user')) {
                $errorMessage .= 'User tidak ditemukan atau akses ditolak.';
            } else {
                $errorMessage .= 'Terjadi kesalahan teknis. Silakan coba beberapa saat lagi.';
            }
            
            return redirect('/login')->with('error', $errorMessage);
        }
    }

    /**
     * Show confirmation page for new Google users
     */
    public function showConfirmation()
    {
        // Ensure user is logged in
        if (!Auth::check() || !session('user.login')) {
            return redirect('/login');
        }
        return view('auth.google_confirm');
    }

    /**
     * Process confirmation and redirect to dashboard
     */
    public function processConfirmation(Request $request)
    {
        if (!Auth::check() || !session('user.login')) {
            return redirect('/login');
        }

        $request->validate([
            'role' => 'required|in:penyewa,pemilik'
        ]);

        $user = Auth::user();
        $role = $request->role;

        // Update user role in database
        $user->role = $role;
        $user->save();

        // Update session
        session(['role' => $role]);
        session(['user.role' => $role]);

        return redirect($this->getDashboardRoute($role));
    }

    /**
     * Redirect to Facebook OAuth
     */
    public function redirectToFacebook()
    {
        // Enforce session start before redirect
        session()->put('oauth_init', true);
        session()->save();
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle Facebook OAuth callback
     */
    public function handleFacebookCallback()
    {
        try {
            // Use stateless to avoid session issues
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
            
            // Find user by Facebook ID first
            $facebookId = $facebookUser->getId();
            $email = $facebookUser->getEmail();
            
            $user = data_user_model::where('facebook_id', $facebookId)->first();
            
            // If not found by Facebook ID, try by email if provided
            if (!$user && $email) {
                $user = data_user_model::where('email', $email)->first();
            }

            $isNewUser = false;

            if ($user) {
                // Update Facebook ID if not set, and update photo if missing
                $updateData = [];
                if (!$user->facebook_id) {
                    $updateData['facebook_id'] = $facebookUser->getId();
                }
                if (!$user->foto_profil || !$user->avatar) {
                    $updateData['avatar'] = $facebookUser->getAvatar();
                    $updateData['foto_profil'] = $user->foto_profil ?? $facebookUser->getAvatar();
                }
                
                if (!empty($updateData)) {
                    $user->update($updateData);
                }
            } else {
                // Create new user
                $isNewUser = true;
                $user = data_user_model::create([
                    'nama_user' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'facebook_id' => $facebookUser->getId(),
                    'avatar' => $facebookUser->getAvatar(),
                    'password' => bcrypt(Str::random(16)), // Random password
                    'role' => 'penyewa', // Default role
                    'nomor_telepon' => null,
                    'alamat' => null,
                    'tanggal_lahir' => null,
                    'jenis_kelamin' => null,
                    'foto_profil' => $facebookUser->getAvatar(),
                ]);
            }

            // Log the user in
            $this->loginUser($user);

            if ($isNewUser) {
                return redirect()->route('google.confirm');
            }

            return redirect($this->getDashboardRoute($user->role));

        } catch (\Exception $e) {
            \Log::error('Facebook OAuth Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Gagal login dengan Facebook. Silakan coba lagi.');
        }
    }

    /**
     * Log the user in and set session
     */
    private function loginUser($user)
    {
        // Set standard Laravel Auth
        Auth::login($user);

        // Set session data matching LoginController
        session([
            'user' => [
                'login' => true,
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->nama_user, // Changed from nama_user to name to match LoginController pattern if needed, but keeping consistent with array keys
                'role' => $user->role,
                'foto_profil' => $user->foto_profil ?? $user->avatar,
                'nomor_telepon' => $user->nomor_telepon,
                'login_time' => now(),
            ],
            // STRICTLY REQUIRED by CekRole middleware
            'role' => $user->role
        ]);
    }

    /**
     * Get dashboard route based on role
     */
    private function getDashboardRoute($role)
    {
        return match($role) {
            'admin' => '/dashboard-admin',
            'pemilik' => '/dashboard-pemilik',
            'penyewa' => '/dashboard-penyewa',
            default => '/dashboard-penyewa',
        };
    }
    /**
     * Redirect to Twitter OAuth
     */
    public function redirectToTwitter()
    {
        try {
            // Enforce session start before redirect
            session()->put('oauth_init', true);
            session()->save();
            return Socialite::driver('twitter')->redirect();
        } catch (\Exception $e) {
            $errorMsg = 'Twitter Redirect Error: ' . $e->getMessage();
            \Log::error($errorMsg);
            // Log full trace to a dedicated file for debugging
            $logMessage = date('Y-m-d H:i:s') . " - " . $errorMsg . "\n" . $e->getTraceAsString() . "\n";
            file_put_contents(storage_path('logs/twitter_debug_redirect.log'), $logMessage, FILE_APPEND);
            
            return response()->json(['error' => 'Twitter Redirect Failed', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle Twitter OAuth callback
     */
    public function handleTwitterCallback()
    {
        try {
            // Twitter OAuth 1.0 doesn't support stateless() in the same way, 
            // but session priming above should help.
            $twitterUser = Socialite::driver('twitter')->user();
            
            // Find user by Twitter ID first
            $twitterId = $twitterUser->getId();
            $email = $twitterUser->getEmail();
            
            $user = data_user_model::where('twitter_id', $twitterId)->first();
            
            // If not found by Twitter ID, try by email if provided
            if (!$user && $email) {
                $user = data_user_model::where('email', $email)->first();
            }

            $isNewUser = false;

            if ($user) {
                // Update Twitter ID if not set, and update photo if missing
                $updateData = [];
                if (!$user->twitter_id) {
                    $updateData['twitter_id'] = $twitterUser->getId();
                }
                if (!$user->foto_profil || !$user->avatar) {
                    $updateData['avatar'] = $twitterUser->getAvatar();
                    $updateData['foto_profil'] = $user->foto_profil ?? $twitterUser->getAvatar();
                }
                
                if (!empty($updateData)) {
                    $user->update($updateData);
                }
            } else {
                // Create new user
                $isNewUser = true;
                $user = data_user_model::create([
                    'nama_user' => $twitterUser->getName(),
                    'email' => $twitterUser->getEmail(),
                    'twitter_id' => $twitterUser->getId(),
                    'avatar' => $twitterUser->getAvatar(),
                    'password' => bcrypt(Str::random(16)), // Random password
                    'role' => 'penyewa', // Default role
                    'nomor_telepon' => null,
                    'alamat' => null,
                    'tanggal_lahir' => null,
                    'jenis_kelamin' => null,
                    'foto_profil' => $twitterUser->getAvatar(),
                ]);
            }

            // Log the user in
            $this->loginUser($user);

            if ($isNewUser) {
                return redirect()->route('google.confirm');
            }

            return redirect($this->getDashboardRoute($user->role));

        } catch (\Exception $e) {
            \Log::error('Twitter OAuth Error: ' . $e->getMessage());
            // Log full trace to a dedicated file for debugging
            $logMessage = date('Y-m-d H:i:s') . " - Twitter Error: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
            file_put_contents(storage_path('logs/oauth_debug.log'), $logMessage, FILE_APPEND);
            
            $errorMessage = 'Gagal login dengan X (Twitter). ';
            if (str_contains($e->getMessage(), 'Could not find a user')) {
                $errorMessage .= 'Akun anda belum terdaftar atau akses ditolak.';
            } else {
                $errorMessage .= 'Terjadi kesalahan sistem. Pastikan anda mengizinkan akses email jika diminta.';
            }
            
            return redirect('/login')->with('error', $errorMessage);
        }
    }
}
