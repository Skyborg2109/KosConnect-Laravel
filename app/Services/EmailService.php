<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->configure();
    }

    private function configure()
    {
        try {
            // Server settings
            $this->mailer->isSMTP();
            $this->mailer->Host = env('MAIL_HOST', 'smtp.gmail.com');
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = env('MAIL_USERNAME');
            $this->mailer->Password = env('MAIL_PASSWORD');
            $this->mailer->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
            $this->mailer->Port = env('MAIL_PORT', 587);

            // Sender info
            $this->mailer->setFrom(
                env('MAIL_FROM_ADDRESS', 'noreply@kosconnect.com'),
                env('MAIL_FROM_NAME', 'KosConnect')
            );

            // Content settings
            $this->mailer->isHTML(true);
            $this->mailer->CharSet = 'UTF-8';
        } catch (Exception $e) {
            \Log::error('Email configuration error: ' . $e->getMessage());
        }
    }

    /**
     * Send OTP verification email
     */
    /**
     * Send OTP verification email
     */
    public function sendOTP(string $email, string $otpCode, string $userName = null, string $token = null): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($email);

            $this->mailer->Subject = 'Kode Verifikasi OTP & Aktivasi Akun - KosConnect';
            
            $displayName = $userName ?? 'Pengguna';
            $activationLink = $token ? url('/verify-email-link/' . $token) : '#';
            
            $this->mailer->Body = $this->getOTPEmailTemplate($otpCode, $displayName, $activationLink);
            $this->mailer->AltBody = "Kode OTP Anda adalah: $otpCode\n\nLink Aktivasi: $activationLink\n\nKode ini berlaku selama 10 menit.\n\nJika Anda tidak meminta kode ini, abaikan email ini.";

            return $this->mailer->send();
        } catch (Exception $e) {
            \Log::error('Failed to send OTP email: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get HTML email template for OTP
     */
    private function getOTPEmailTemplate(string $otpCode, string $userName, string $activationLink): string
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 40px auto;
                    background: white;
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                }
                .header {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    padding: 30px;
                    text-align: center;
                    color: white;
                }
                .header h1 {
                    margin: 0;
                    font-size: 28px;
                    font-weight: 600;
                }
                .content {
                    padding: 40px 30px;
                }
                .greeting {
                    font-size: 18px;
                    color: #333;
                    margin-bottom: 20px;
                }
                .message {
                    color: #666;
                    line-height: 1.6;
                    margin-bottom: 30px;
                }
                .otp-box {
                    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
                    border: 2px dashed #667eea;
                    border-radius: 12px;
                    padding: 30px;
                    text-align: center;
                    margin: 30px 0;
                }
                .otp-code {
                    font-size: 36px;
                    font-weight: 700;
                    color: #667eea;
                    letter-spacing: 8px;
                    margin: 10px 0;
                }
                .otp-label {
                    font-size: 14px;
                    color: #666;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }
                .btn-container {
                    text-align: center;
                    margin: 30px 0;
                }
                .btn {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    padding: 12px 24px;
                    text-decoration: none;
                    border-radius: 8px;
                    font-weight: 600;
                    display: inline-block;
                    box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
                }
                .separator {
                    text-align: center;
                    color: #999;
                    margin: 20px 0;
                    font-size: 14px;
                    position: relative;
                }
                .separator::before, .separator::after {
                    content: '';
                    display: inline-block;
                    width: 30%;
                    height: 1px;
                    background: #eee;
                    vertical-align: middle;
                    margin: 0 10px;
                }
                .expiry {
                    background: #fff3cd;
                    border-left: 4px solid #ffc107;
                    padding: 15px;
                    margin: 20px 0;
                    border-radius: 4px;
                    color: #856404;
                }
                .footer {
                    background: #f8f9fa;
                    padding: 20px 30px;
                    text-align: center;
                    color: #666;
                    font-size: 14px;
                    border-top: 1px solid #e9ecef;
                }
                .warning {
                    color: #dc3545;
                    font-size: 13px;
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>🏠 KosConnect</h1>
                </div>
                <div class='content'>
                    <div class='greeting'>Halo, $userName!</div>
                    <div class='message'>
                        Terima kasih telah mendaftar di KosConnect. Silakan gunakan metode di bawah ini untuk mengaktifkan akun Anda.
                    </div>
                    
                    <div class='otp-box'>
                        <div class='otp-label'>Kode Verifikasi OTP</div>
                        <div class='otp-code'>$otpCode</div>
                    </div>
                    
                    <div class='separator'>ATAU</div>
                    
                    <div class='btn-container'>
                        <a href='$activationLink' class='btn'>Aktifkan Akun Saya</a>
                    </div>
                    
                    <div class='expiry'>
                        ⏰ <strong>Penting:</strong> Kode dan link ini berlaku selama <strong>10 menit</strong>.
                    </div>
                    <div class='message'>
                        Jika tombol di atas tidak berfungsi, Anda dapat menggunakan kode OTP pada halaman verifikasi.
                    </div>
                    <div class='warning'>
                        ⚠️ Jika Anda tidak meminta kode ini, abaikan email ini. 
                        Jangan bagikan kode OTP Anda kepada siapa pun.
                    </div>
                </div>
                <div class='footer'>
                    <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
                    <p>&copy; " . date('Y') . " KosConnect. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
