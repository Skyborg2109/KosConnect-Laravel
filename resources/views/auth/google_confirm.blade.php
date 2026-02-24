<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang! | KosConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            animation: fadeIn 0.8s ease-out;
        }

        .avatar-container {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #f3f3f3;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .avatar-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 500;
            font-size: 14px;
        }

        select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            color: #4a5568;
            background-color: #f8fafc;
            transition: all 0.3s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }

        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-continue {
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(118, 75, 162, 0.4);
            width: 100%;
        }

        .btn-continue:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(118, 75, 162, 0.6);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="avatar-container">
            <img src="{{ session('user.foto_profil') ?? 'https://via.placeholder.com/100' }}" alt="Profile Picture">
        </div>
        <h1>Selamat Datang, {{ explode(' ', session('user.name'))[0] }}!</h1>
        <p>Akun anda berhasil dibuat. Silakan pilih peran anda untuk melanjutkan.</p>
        
        <form action="{{ route('google.confirm.process') }}" method="GET">
            <div class="form-group">
                <label for="role">Saya ingin mendaftar sebagai:</label>
                <select name="role" id="role" required onchange="checkSelection()">
                    <option value="" disabled selected>-- Pilih Peran Anda --</option>
                    <option value="penyewa">Penyewa (Cari Kos)</option>
                    <option value="pemilik">Pemilik Kos (Sewakan Kos)</option>
                </select>
            </div>
            <button type="submit" class="btn-continue" id="btnContinue" disabled style="opacity: 0.6; cursor: not-allowed;">Lanjutkan Dashboard</button>
        </form>
    </div>

    <script>
        function checkSelection() {
            const role = document.getElementById('role').value;
            const btn = document.getElementById('btnContinue');
            if (role) {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.cursor = 'pointer';
            } else {
                btn.disabled = true;
                btn.style.opacity = '0.6';
                btn.style.cursor = 'not-allowed';
            }
        }
    </script>
</body>
</html>
