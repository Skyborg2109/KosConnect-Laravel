<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kos Baru - KosConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: white;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .pemilik-profile {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid #334155;
        }

                <div class="pemilik-avatar" style="overflow: hidden;">
                    @if(session('user.foto_profil'))
                        <img src="{{ session('user.foto_profil') }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>

        .pemilik-avatar:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .pemilik-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .pemilik-role {
            font-size: 12px;
            color: #94a3b8;
        }

        .menu {
            flex: 1;
            padding: 20px 0;
        }

        .menu-item {
            padding: 15px 25px;
            display: flex;
            align-items: center;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .menu-item:hover::before {
            left: 100%;
        }

        .menu-item:hover {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .menu-item.active {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            color: white;
            border-left: 3px solid #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .menu-item i {
            margin-right: 25px;
            width: 20px;
        }

        .logout-btn {
            margin: 20px;
            padding: 12px;
            background-color: #475569;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .logout-btn:hover {
            background-color: #64748b;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background-color: white;
            padding: 20px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title h1 {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
        }

        .header-icons {
            display: flex;
            gap: 15px;
        }

        .icon-btn {
            width: 40px;
            height: 40px;
            background-color: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
            color: #64748b;
            border: none;
        }

        .icon-btn:hover {
            background-color: #e2e8f0;
        }

        .icon-btn.active {
            background-color: #3b82f6;
            color: white;
        }

        .icon-btn.active:hover {
            background-color: #2563eb;
        }

        /* Content */
        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 30px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 30px;
        }

        /* Form Container */
        .form-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #7c3aed, #3b82f6, #06b6d4);
            transform: scaleX(1);
            transform-origin: left;
        }

        .form-title {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #374151;
            display: flex;
            align-items: center;
            gap: 8px;
        }

                .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #ffffff;
            transition: all 0.3s ease;
            background-color: #ffffff;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
            transform: translateY(-2px);
        }"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .form-group select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%208l5%205%205-5z%22%20fill%3D%22%236c757d%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #9ca3af;
        }

        /* Grid untuk Harga dan Jumlah Kamar */
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Grid untuk Fasilitas */
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 16px;
            border-radius: 8px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
        .checkbox-item {
            display: flex;
            align-items: center;
        }

        .checkbox-item input {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            accent-color: #7c3aed;
        }

        .checkbox-item label {
            margin-bottom: 0;
            font-weight: 400;
            font-size: 14px;
            color: #374151;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 40px;
            gap: 15px;
            margin-top: 40px;
        }

        .btn {
            padding: 12px 32px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280, #9ca3af);
            color: white;
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563, #6b7280);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.4);
        }

        .btn-primary {
            background: linear-gradient(135deg, #7c3aed, #3b82f6);
            color: white;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5b21b6, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #495057;
        }

        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }

            .form-container {
                padding: 30px 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* == ANIMASI == */
        /* == ANIMASI == */
        body {
            /* Animation removed */
        }
        
        .sidebar {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        .menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: width 0.5s ease;
        }

        .menu-item:hover::before {
            width: 100%;
        }

        .btn {
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .logout-btn:hover::before {
            left: 100%;
        }
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: #3b82f6;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            align-items: center;
            justify-content: center;
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .mobile-overlay.active {
            display: block;
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
            }

            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
                z-index: 1000;
                width: 280px;
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(280px);
            }

            .main-content {
                width: 100%;
                margin-left: 0;
            }

            .header {
                padding: 15px 15px 15px 70px;
            }

            .content {
                padding: 20px 15px;
            }

            .form-grid-2 {
                grid-template-columns: 1fr;
            }

            .checkbox-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
        <i class="fas fa-bars"></i>
    </button>
    <div class="mobile-overlay" onclick="toggleMobileMenu()"></div>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="pemilik-profile">
                <div class="pemilik-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="pemilik-name">Pemilik Kos</div>
                <div class="pemilik-role">Status:<br>Pemilik</div>
            </div>

            <div class="menu">
                <a href="/dashboard-pemilik" class="menu-item">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>

                <a href="/pemilik/manajemen-kos" class="menu-item active">
                    <i class="fas fa-building"></i>
                    <span>Manajemen Kos</span>
                </a>

                <a href="/pemilik/verifikasi-pembayaran" class="menu-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Verifikasi Pembayaran</span>
                </a>

                <a href="/pemilik/kelola-pesanan" class="menu-item">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Kelola Pesanan</span>
                </a>

                <a href="/pemilik/keluhan-kos" class="menu-item">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Keluhan Kos</span>
                </a>



                <a href="/profil-pemilik" class="menu-item">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil Saya</span>
                </a>
            </div>

            <form method="POST" action="/logout-pemilik" style="display: inline;">
                @csrf
                <button type="button" class="logout-btn" onclick="confirmLogout(this.form)">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-title">
                    <h1>Tambah Kos Baru</h1>
                </div>
                <div class="header-icons">
                    <form method="GET" action="#" style="display: inline;">
                        @csrf
                        <button type="button" class="icon-btn">
                            <i class="fas fa-bell"></i>
                        </button>
                    </form>
                    <form method="GET" action="/profil-pemilik" style="display: inline;">
                        @csrf
                        <button type="submit" class="icon-btn">
                            <i class="fas fa-user"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                <a href="/pemilik/manajemen-kos" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Manajemen Kos
                </a>

                <div class="form-container">
                    <h2 class="form-title">
                        <i class="fas fa-plus-circle"></i>
                        Tambah Kos Baru
                    </h2>

                    <form method="POST" action="/tambah-kos" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="nama-kos">
                                <i class="fas fa-building"></i>
                                Nama Kos
                            </label>
                            <input type="text" id="nama-kos" name="nama_kos" placeholder="Masukkan nama kos" required>
                        </div>

                        <div class="form-group">
                            <label for="pemilik-kos">
                                <i class="fas fa-user"></i>
                                Pemilik Kos
                            </label>
                            <select id="pemilik-kos" name="pemilik_kos" required>
                                <option value="" disabled selected>Pilih Pemilik</option>
                                <option value="thobroni">Thobroni</option>
                                <option value="biylork">BiyLork</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="alamat-kos">
                                <i class="fas fa-map-marker-alt"></i>
                                Alamat
                            </label>
                            <textarea id="alamat-kos" name="alamat_kos" placeholder="Masukkan alamat lengkap kos" required></textarea>
                        </div>

                        <div class="form-grid-2">
                            <div class="form-group">
                                <label for="harga-kos">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Harga per Bulan (Rp)
                                </label>
                                <input type="number" id="harga-kos" name="harga_kos" placeholder="cth: 800000" required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah-kamar">
                                    <i class="fas fa-door-open"></i>
                                    Jumlah Kamar
                                </label>
                                <input type="number" id="jumlah-kamar" name="jumlah_kamar" placeholder="cth: 20" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi-kos">
                                <i class="fas fa-file-alt"></i>
                                Deskripsi
                            </label>
                            <textarea id="deskripsi-kos" name="deskripsi_kos" placeholder="Tulis deskripsi singkat kos"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="gambar-kos">
                                <i class="fas fa-images"></i>
                                Foto Kos (Bisa pilih banyak)
                            </label>
                            <input type="file" id="gambar-kos" name="gambar[]" multiple accept="image/*" onchange="previewImages(this)">
                            <div id="image-preview-container" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;"></div>
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-concierge-bell"></i>
                                Fasilitas
                            </label>
                            <div class="checkbox-grid">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="fas-wifi" name="fasilitas[]" value="WiFi">
                                    <label for="fas-wifi">WiFi</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="fas-ac" name="fasilitas[]" value="AC">
                                    <label for="fas-ac">AC</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="fas-km-dalam" name="fasilitas[]" value="KM Dalam">
                                    <label for="fas-km-dalam">KM Dalam</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="fas-parkir" name="fasilitas[]" value="Parkir">
                                    <label for="fas-parkir">Parkir</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="fas-kasur" name="fasilitas[]" value="Kasur">
                                    <label for="fas-kasur">Kasur</label>
                                </div>
                                <div class="checkbox-item">
                                    <input type="checkbox" id="fas-meja" name="fasilitas[]" value="Meja">
                                    <label for="fas-meja">Meja</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <a href="/pemilik/manajemen-kos" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Simpan Kos Baru
                            </button>
                        </div>
                    </form>

                    <script>
                        function previewImages(input) {
                            var container = document.getElementById('image-preview-container');
                            container.innerHTML = '';
                            
                            if (input.files) {
                                Array.from(input.files).forEach(file => {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        var div = document.createElement('div');
                                        div.style.width = '100px';
                                        div.style.height = '100px';
                                        div.style.borderRadius = '8px';
                                        div.style.overflow = 'hidden';
                                        div.style.border = '1px solid #ddd';
                                        
                                        var img = document.createElement('img');
                                        img.src = e.target.result;
                                        img.style.width = '100%';
                                        img.style.height = '100%';
                                        img.style.objectFit = 'cover';
                                        
                                        div.appendChild(img);
                                        container.appendChild(div);
                                    }
                                    reader.readAsDataURL(file);
                                });
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    @include('components.sweetalert')
    <script>
        function toggleMobileMenu() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    toggleMobileMenu();
                }
            });
        });
    </script>
</body>
</html>