<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi OTP - KosConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 480px;
            width: 100%;
            padding: 40px;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header .icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .header .icon i {
            font-size: 36px;
            color: white;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .email-display {
            background: #f8f9fa;
            padding: 12px 16px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 25px;
            border: 1px solid #e9ecef;
        }

        .email-display strong {
            color: #667eea;
            font-weight: 600;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert i {
            font-size: 16px;
        }

        .otp-input-group {
            margin-bottom: 25px;
        }

        .otp-input-group label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .otp-inputs input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            transition: all 0.3s;
            color: #333;
        }

        .otp-inputs input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .timer {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-radius: 10px;
            border: 1px solid #ffc107;
        }

        .timer i {
            color: #856404;
            margin-right: 8px;
        }

        .timer span {
            font-weight: 600;
            color: #856404;
            font-size: 18px;
        }

        .timer.expired {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-color: #dc3545;
        }

        .timer.expired i,
        .timer.expired span {
            color: #721c24;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-btn:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .resend-section {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .resend-section p {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .resend-btn {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .resend-btn:hover:not(:disabled) {
            background: #667eea;
            color: white;
        }

        .resend-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }

            .otp-inputs input {
                width: 45px;
                height: 55px;
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <h1>Verifikasi Email</h1>
            <p>Masukkan kode OTP 6 digit yang telah dikirim ke email Anda</p>
        </div>

        <div class="email-display">
            <i class="fas fa-envelope"></i> <strong>{{ $email }}</strong>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="timer" id="timer">
            <i class="fas fa-clock"></i>
            <span id="countdown">10:00</span>
        </div>

        <form action="/verify-otp" method="POST" id="otpForm">
            @csrf
            <div class="otp-input-group">
                <label>Kode OTP</label>
                <div class="otp-inputs">
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="otp-digit" id="otp1" autofocus>
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="otp-digit" id="otp2">
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="otp-digit" id="otp3">
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="otp-digit" id="otp4">
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="otp-digit" id="otp5">
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" class="otp-digit" id="otp6">
                </div>
                <input type="hidden" name="otp_code" id="otpCode">
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">Verifikasi</button>
        </form>

        <div class="resend-section">
            <p>Tidak menerima kode?</p>
            <button type="button" class="resend-btn" id="resendBtn" disabled>
                <i class="fas fa-redo"></i> Kirim Ulang OTP
            </button>
        </div>

        <div class="back-link">
            <a href="/login"><i class="fas fa-arrow-left"></i> Kembali ke Login</a>
        </div>
    </div>

    <script>
        // OTP Input Handling
        const otpInputs = document.querySelectorAll('.otp-digit');
        const otpCodeInput = document.getElementById('otpCode');
        const submitBtn = document.getElementById('submitBtn');
        const otpForm = document.getElementById('otpForm');

        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const value = e.target.value;
                
                // Only allow numbers
                if (!/^\d$/.test(value)) {
                    e.target.value = '';
                    return;
                }

                // Move to next input
                if (value && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }

                // Update hidden input
                updateOtpCode();
            });

            input.addEventListener('keydown', (e) => {
                // Handle backspace
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    otpInputs[index - 1].focus();
                }

                // Handle paste
                if (e.key === 'v' && (e.ctrlKey || e.metaKey)) {
                    e.preventDefault();
                    navigator.clipboard.readText().then(text => {
                        const digits = text.replace(/\D/g, '').slice(0, 6);
                        digits.split('').forEach((digit, i) => {
                            if (otpInputs[i]) {
                                otpInputs[i].value = digit;
                            }
                        });
                        updateOtpCode();
                        if (digits.length === 6) {
                            otpInputs[5].focus();
                        }
                    });
                }
            });
        });

        function updateOtpCode() {
            const code = Array.from(otpInputs).map(input => input.value).join('');
            otpCodeInput.value = code;
            submitBtn.disabled = code.length !== 6;
        }

        // Timer Countdown
        const expiresAt = new Date('{{ $expiresAt }}');
        const timerElement = document.getElementById('timer');
        const countdownElement = document.getElementById('countdown');
        const resendBtn = document.getElementById('resendBtn');

        function updateCountdown() {
            const now = new Date();
            const diff = expiresAt - now;

            if (diff <= 0) {
                countdownElement.textContent = '00:00';
                timerElement.classList.add('expired');
                countdownElement.parentElement.innerHTML = '<i class="fas fa-exclamation-triangle"></i> <span>Kode OTP telah kadaluarsa</span>';
                submitBtn.disabled = true;
                resendBtn.disabled = false;
                return;
            }

            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            setTimeout(updateCountdown, 1000);
        }

        updateCountdown();

        // Resend OTP
        resendBtn.addEventListener('click', async () => {
            resendBtn.disabled = true;
            resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

            try {
                const response = await fetch('/resend-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Update expiry time and restart countdown
                    expiresAt.setTime(new Date(data.expires_at).getTime());
                    timerElement.classList.remove('expired');
                    countdownElement.parentElement.innerHTML = '<i class="fas fa-clock"></i> <span id="countdown"></span>';
                    updateCountdown();

                    // Clear OTP inputs
                    otpInputs.forEach(input => input.value = '');
                    otpInputs[0].focus();
                    updateOtpCode();

                    // Show success message
                    alert(data.message);
                } else {
                    alert(data.message || 'Gagal mengirim ulang OTP');
                    resendBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                resendBtn.disabled = false;
            }

            resendBtn.innerHTML = '<i class="fas fa-redo"></i> Kirim Ulang OTP';
        });

        // Auto-submit when all digits are filled
        otpForm.addEventListener('submit', (e) => {
            if (otpCodeInput.value.length !== 6) {
                e.preventDefault();
                alert('Silakan masukkan 6 digit kode OTP');
            }
        });
    </script>
</body>
</html>
