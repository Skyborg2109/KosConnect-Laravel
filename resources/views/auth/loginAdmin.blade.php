<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - KosConnect</title>
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
            background-color: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            width: 400px;
            max-width: 100%;
            padding: 40px;
            text-align: center;
        }

        .container h1 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .container .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
        }

        .form-group input::placeholder {
            color: #999;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: transform 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #abb4d9;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: none;
        }

        .admin-icon {
            font-size: 48px;
            color: #afb6d4;
            margin-bottom: 20px;
        }

        /* Alert Styles */
        .alert {
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 12px;
            line-height: 1.3;
        }

        .alert-danger {
            background-color: rgba(200, 50, 50, 0.15);
            border: 1px solid rgba(200, 50, 50, 0.3);
            color: #c33;
        }

        .alert i {
            margin-right: 5px;
            font-size: 11px;
        }

        @media (max-width: 480px) {
            .container {
                width: 90%;
                padding: 30px 20px;
            }

            .container h1 {
                font-size: 24px;
                color: #222;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="admin-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <h1>Login Admin</h1>
        <p class="subtitle">Silahkan Masukkan Akun Admin Anda</p>

        @if(session('login_error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('login_error') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form action="/masuk-admin" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email" >
                @error('email')
                    <div class="alert alert-danger" style="margin-top: 5px; margin-bottom: 0;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" value="{{ old('password') }}" placeholder="Masukkan Password">
                @error('password')
                    <div class="alert alert-danger" style="margin-top: 5px; margin-bottom: 0;">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <input type="hidden" name="role" value="admin">

            <button type="submit" class="submit-btn">Login</button>
        </form>

        <a href="/" class="back-link">← Kembali ke Login Utama</a>
    </div>
</body>
</html>
