<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="{{ asset('images/logo-kosconnect.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register - KosConnect</title>
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
            background-image: url('{{ asset('images/bg-01.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background-color: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 0.2rem;
            box-shadow: 0 18px 40px rgba(11,22,40,0.14), 0 10px 18px rgba(11,22,40,0.06);
            position: relative;
            overflow: hidden;
            width: 850px;
            max-width: 100%;
            min-height: 550px;
        }
        
        /* Form Containers */
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
            background-color: transparent;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            opacity: 1;
            visibility: visible;
        }

        /* subtle pale panels for forms (left/right depending on state) */
        .sign-in-container,
        .sign-up-container {
            /* make the form card much more transparent so background shows through */
            background: rgba(255,255,255,0.06);
            padding: 48px 40px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: none;
            border-radius: 0.2rem; /* use container radius only */
            margin: 0; /* align edges with container */
            box-sizing: border-box;
        }

        /* ensure inner form area stays readable but light */
        .sign-in-container form,
        .sign-up-container form {
            background: transparent;
            padding: 12px 0 40px 0;
            border-radius: 0.2rem;
            width: 100%;
            box-sizing: border-box;
        }
        
        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
            opacity: 1;
            pointer-events: auto;
        }

        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
            opacity: 0;
            pointer-events: none;
            visibility: hidden;
            z-index: 1;
        }
        
        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
            pointer-events: none;
            visibility: hidden;
        }

        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            pointer-events: auto;
            visibility: visible;
            animation: show 0.6s;
        }
        
        @keyframes show {
            0%, 49.99% {
                opacity: 0;
                z-index: 1;
            }
            50%, 100% {
                opacity: 1;
                z-index: 5;
            }
        }
        
        form {
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            text-align: center;
        }
        
        form h2 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        
        form .subtitle {
            font-size: 13px;
            margin-bottom: 15px;
            color: #2d0060;
        }
        
        .form-group {
            width: 100%;
            margin-bottom: 8px;
        }
        
        .form-group label {
            display: block;
            color: #333;
            font-size: 13px;
            font-weight: 400;
            margin-bottom: 5px;
            text-align: left;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 0.2rem;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            background: rgba(255,255,255,0.92);
            color: #333;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.6);
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            background: #fff;
            border-color: #667eea;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.2);
        }
        
        .form-group input::placeholder {
            color: #999;
            font-size: 13px;
        }
        
        .form-group input.is-invalid,
        .form-group select.is-invalid {
            border: 1.5px solid #ff4d4d;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 4px rgba(255, 77, 77, 0.2);
        }
        
        .password-toggle {
            position: relative;
        }
        
        .password-toggle input {
            padding-right: 40px;
        }
        
        .password-toggle i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            cursor: pointer;
            font-size: 14px;
        }
        
        .submit-btn {
            width: 100%;
            padding: 11px;
            background: linear-gradient(135deg, #667eea 0%, #b24ec9 100%);
            color: white;
            border: none;
            border-radius: 0.2rem;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: transform 80ms ease-in;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .submit-btn:active {
            transform: scale(0.95);
        }
        
        .alt-login {
            text-align: center;
            margin-top: 10px;
            color: #2d0060;
            font-size: 12px;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 12px;
        }
        
        .social-icons a {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .social-icons a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.05);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .social-icons a:hover::before {
            opacity: 1;
        }
        
        .social-icons a:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        .social-icons a.google {
            color: #EA4335;
        }
        
        .social-icons a.twitter {
            color: #000000;
        }

        .social-icons a.x-twitter {
            color: #000000;
        }
        
        /* Overlay Container */
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }
        
        .container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }
        
        .overlay {
            background: linear-gradient(135deg, #3b0f4d 0%, #6b2ea3 45%, #b24ec9 100%);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            color: #FFFFFF;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
            box-shadow: inset 0 0 80px rgba(0,0,0,0.18);
            border-radius: 0 0.2rem 0.2rem 0;
        }
        
        .overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0,0,0,0.06), rgba(0,0,0,0.12));
        }

        /* vertical divider line */
        .container::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 6%;
            bottom: 6%;
            width: 1px;
            background: rgba(0,0,0,0.06);
            transform: translateX(-0.5px);
            z-index: 60;
            pointer-events: none;
        }
        
        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }
        
        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
            z-index: 1;
        }
        
        .overlay-panel h2 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
            color: white;
        }
        
        .overlay-panel p {
            font-size: 11px;
            margin-bottom: 25px;
            color: white;
            line-height: 1.5;
        }
        
        .overlay-left {
            transform: translateX(-20%);
        }
        
        .container.right-panel-active .overlay-left {
            transform: translateX(0);
        }
        
        .overlay-right {
            right: 0;
            transform: translateX(0);
        }
        
        .container.right-panel-active .overlay-right {
            transform: translateX(20%);
        }
        
        .ghost-btn {
            background-color: transparent;
            border: 2px solid white;
            color: white;
            padding: 12px 45px;
            border-radius: 0.2rem;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .ghost-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .ghost-btn:active {
            transform: scale(0.95);
        }

        /* Alert Styles */
        .alert {
            padding: 6px 10px;
            border-radius: 4px;
            margin-top: 4px;
            margin-bottom: 0;
            font-size: 11px;
            line-height: 1.3;
            display: flex;
            align-items: center;
            width: 100%;
            box-sizing: border-box;
            animation: fadeInDown 0.2s ease-out;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-danger {
            background-color: rgba(255, 255, 255, 0.95);
            border-left: 3px solid #ff4d4d;
            color: #d32f2f;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .alert-success {
            background-color: rgba(255, 255, 255, 0.95);
            border-left: 3px solid #2ecc71;
            color: #27ae60;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Field Error Specific (Ultra Compact) */
        .alert.alert-item {
            background: none !important;
            border: none !important;
            box-shadow: none !important;
            padding: 2px 0 0 2px !important;
            margin-top: 2px;
            color: #fff;
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
            font-weight: 500;
            backdrop-filter: none;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .alert-item i {
            margin-right: 6px;
            font-size: 11px;
            color: #ff4d4d;
            filter: drop-shadow(0 0 2px rgba(255, 0, 0, 0.8));
        }
        
        /* Mobile Tab Navigation */
        .mobile-tabs {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 200;
        }

        .mobile-tabs-container {
            display: flex;
            width: 100%;
        }

        .mobile-tab {
            flex: 1;
            padding: 16px;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
        }

        .mobile-tab::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(135deg, #667eea 0%, #b24ec9 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .mobile-tab.active {
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        .mobile-tab.active::after {
            transform: scaleX(1);
        }

        @media (max-width: 768px) {
            body {
                padding: 0;
                align-items: flex-start;
            }

            .container {
                width: 100%;
                min-height: 100vh;
                border-radius: 0;
                padding-top: 56px; /* Height of mobile tabs */
            }

            .mobile-tabs {
                display: block;
            }
            
            /* Hide desktop overlay completely */
            .overlay-container {
                display: none !important;
            }
            
            /* Form containers - stack vertically */
            .form-container {
                position: relative !important;
                width: 100% !important;
                height: auto !important;
                transform: none !important;
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
                transition: none !important;
            }

            .sign-in-container,
            .sign-up-container {
                padding: 32px 24px;
                min-height: calc(100vh - 56px);
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            /* Hide inactive form on mobile */
            .sign-in-container {
                display: block;
            }

            .sign-up-container {
                display: none;
            }

            .container.right-panel-active .sign-in-container {
                display: none;
            }

            .container.right-panel-active .sign-up-container {
                display: block;
            }
            
            h2 {
                font-size: 28px;
                margin-bottom: 8px;
            }

            .subtitle {
                font-size: 14px;
                margin-bottom: 24px;
            }
            
            form {
                padding: 0;
            }

            .form-group {
                margin-bottom: 16px;
            }
            
            input, select {
                height: 48px;
                font-size: 15px;
                padding: 0 16px;
            }

            .password-toggle {
                height: 48px;
            }

            .password-toggle input {
                padding-right: 48px;
            }

            .password-toggle i {
                font-size: 16px;
                right: 16px;
            }
            
            .submit-btn {
                height: 48px;
                font-size: 15px;
                margin-top: 12px;
            }
            
            .alt-login {
                font-size: 13px;
                margin-top: 16px;
            }
            
            .social-icons {
                margin-top: 16px;
                gap: 16px;
            }
            
            .social-icons a {
                width: 52px;
                height: 52px;
                font-size: 20px;
            }

            .alert {
                font-size: 12px;
                padding: 8px 12px;
            }
        }

        /* Admin Login Floating Button */
        .admin-login-fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #667eea 0%, #b24ec9 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4), 
                        0 4px 12px rgba(178, 78, 201, 0.3);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            text-decoration: none;
            border: 3px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .admin-login-fab::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: linear-gradient(135deg, #667eea 0%, #b24ec9 100%);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
            filter: blur(8px);
        }

        .admin-login-fab:hover::before {
            opacity: 0.6;
        }

        .admin-login-fab:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.5), 
                        0 6px 16px rgba(178, 78, 201, 0.4);
        }

        .admin-login-fab:active {
            transform: translateY(-2px) scale(1.02);
        }

        .admin-login-fab i {
            font-size: 28px;
            color: white;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .admin-login-fab .tooltip {
            position: absolute;
            right: 75px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #333;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .admin-login-fab .tooltip::after {
            content: '';
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 6px solid rgba(255, 255, 255, 0.95);
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
        }

        .admin-login-fab:hover .tooltip {
            opacity: 1;
            right: 80px;
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4), 
                            0 4px 12px rgba(178, 78, 201, 0.3);
            }
            50% {
                box-shadow: 0 8px 32px rgba(102, 126, 234, 0.6), 
                            0 4px 16px rgba(178, 78, 201, 0.5);
            }
        }

        @media (max-width: 768px) {
            .admin-login-fab {
                width: 56px;
                height: 56px;
                bottom: 20px;
                right: 20px;
            }

            .admin-login-fab i {
                font-size: 24px;
            }

            .admin-login-fab .tooltip {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding-top: 56px;
            }

            .sign-in-container,
            .sign-up-container {
                padding: 24px 20px;
            }

            h2 {
                font-size: 24px;
            }

            .subtitle {
                font-size: 13px;
            }

            input, select {
                height: 44px;
                font-size: 14px;
            }

            .submit-btn {
                height: 44px;
                font-size: 14px;
            }

            .admin-login-fab {
                width: 52px;
                height: 52px;
                bottom: 16px;
                right: 16px;
            }

            .admin-login-fab i {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <!-- Mobile Tab Navigation -->
        <div class="mobile-tabs">
            <div class="mobile-tabs-container">
                <button class="mobile-tab active" id="mobileLoginTab">Login</button>
                <button class="mobile-tab" id="mobileRegisterTab">Register</button>
            </div>
        </div>

        <!-- Sign Up Form -->
        <div class="form-container sign-up-container">
            <form action='/daftar' method="POST">
                @csrf
                <h2>Register</h2>
                <p class="subtitle">Buat Akun Anda</p>
                
                <div class="form-group">
                    <input type="text" name="nama_user" 
                    value="{{ old('nama_user') }}"
                    placeholder="Masukkan Username" 
                    class="{{ $errors->has('nama_user') ? 'is-invalid' : '' }}">
                    @error('nama_user')
                        <div class="alert alert-danger alert-item">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email')
                        <div class="alert alert-danger alert-item">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="password-toggle">
                        <input type="password" id="password-register" name="password" placeholder="Masukkan Password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                        <i class="fas fa-eye" onclick="togglePasswordRegister()"></i>
                    </div>
                    @error('password')
                        <div class="alert alert-danger alert-item">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <select name="role" class="{{ $errors->has('role') ? 'is-invalid' : '' }}">
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                        <option value="penyewa" {{ old('role') == 'penyewa' ? 'selected' : '' }}>Penyewa Kos</option>
                        <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>Pemilik Kost</option>
                    </select>
                    @error('role')
                        <div class="alert alert-danger alert-item">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <button type="submit" class="submit-btn">Register</button>

                <div class="alt-login">Atau Daftar Dengan</div>
                
                <div class="social-icons">
                    <a href="/auth/google" class="google" title="Daftar dengan Google">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a href="/auth/twitter" class="x-twitter" title="Daftar dengan X">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                </div>

            </form>
        </div>
        
        <!-- Sign In Form -->
        <div class="form-container sign-in-container">
            <form action='/masuk' method="POST">
                @csrf
                <h2>Login</h2>
                <p class="subtitle">Silahkan Login Ke Akun Anda</p>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="form-group">
                    <input type="email" name="email" placeholder="Masukkan Email" value="{{ old('email') }}">
                    @error('email')
                        <div class="alert alert-danger alert-item">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    @error('email_not_found')
                        <div class="alert alert-danger alert-item">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div class="password-toggle">
                        <input type="password" id="password-login" name="password" placeholder="Masukkan Password" value="{{ session('password_value') ?? old('password') }}">
                        <i class="fas fa-eye" onclick="togglePasswordLogin()"></i>
                    </div>
                    @error('password')
                        <div class="alert alert-danger alert-item">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    @error('password_wrong')
                        <div class="alert alert-danger alert-item">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <select name="role" value="{{ old('role') }}">
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="penyewa" {{ old('role') == 'penyewa' ? 'selected' : '' }}>Penyewa Kos</option>
                        <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>Pemilik Kost</option>
                    </select>
                    @error('role')
                        <div class="alert alert-danger alert-item">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    @error('role_not_match')
                        <div class="alert alert-danger alert-item">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <button type="submit" class="submit-btn">Login</button>
                
                <div class="alt-login">Atau Login Dengan</div>
                
                <div class="social-icons">
                    <a href="/auth/google" class="google" title="Login dengan Google">
                        <i class="fa-brands fa-google"></i>
                    </a>
                    <a href="/auth/twitter" class="x-twitter" title="Login dengan X">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Overlay Container -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h2>Mulai Perjalanan Anda<br>Bersama KosConnect !</h2>
                    <p>Sudah Memiliki akun? Login Sekarang !</p>
                    <button class="ghost-btn" id="signIn">Login</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h2>Selamat Datang Kembali<br>Di Aplikasi KosConnect !</h2>
                    <p>Belum Memiliki akun? Register Disini !</p>
                    <button class="ghost-btn" id="signUp">Register</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
        const mobileLoginTab = document.getElementById('mobileLoginTab');
        const mobileRegisterTab = document.getElementById('mobileRegisterTab');

        // Desktop overlay buttons
        if (signUpButton) {
            signUpButton.addEventListener('click', () => {
                container.classList.add("right-panel-active");
                updateMobileTabs(false);
            });
        }

        if (signInButton) {
            signInButton.addEventListener('click', () => {
                container.classList.remove("right-panel-active");
                updateMobileTabs(true);
            });
        }

        // Mobile tab buttons
        mobileLoginTab.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
            updateMobileTabs(true);
        });

        mobileRegisterTab.addEventListener('click', () => {
            container.classList.add("right-panel-active");
            updateMobileTabs(false);
        });

        // Update mobile tab active states
        function updateMobileTabs(isLogin) {
            if (isLogin) {
                mobileLoginTab.classList.add('active');
                mobileRegisterTab.classList.remove('active');
            } else {
                mobileLoginTab.classList.remove('active');
                mobileRegisterTab.classList.add('active');
            }
        }

        // Check if there are validation errors on register form
        // If yes, automatically show the register form
        @if($errors->has('nama_user') || $errors->has('email') && old('nama_user') || $errors->has('password') && old('nama_user') || $errors->has('role') && old('nama_user'))
            container.classList.add("right-panel-active");
            updateMobileTabs(false);
        @endif

        function togglePasswordLogin() {
            const passwordField = document.getElementById('password-login');
            const icon = event.target;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function togglePasswordRegister() {
            const passwordField = document.getElementById('password-register');
            const icon = event.target;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

    <!-- Admin Login Floating Button -->
    <a href="/login-admin" class="admin-login-fab" title="Login Admin">
        <span class="tooltip">Login Admin</span>
        <i class="fas fa-user-shield"></i>
    </a>

</body>
</html>
