<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Admin - KosConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        }

        .admin-profile {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid #334155;
        }

        .admin-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .admin-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .admin-role {
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
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .menu-item:hover {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            color: white;
            transform: translateX(3px);
        }

        .menu-item.active {
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            color: white;
            border-left: 3px solid #3b82f6;
        }

        .menu-item i {
            margin-right: 15px;
            width: 20px;
        }

        .logout-btn {
            margin: 20px 15px;
            padding: 14px 20px;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border: none;
            color: white;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
            width: calc(100% - 30px);
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .logout-btn:hover::before {
            left: 100%;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
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

        .logout-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 24px;
            color: #1e293b;
        }

        /* Profile Content */
        .profile-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #1e293b;
        }

        .profile-card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        .profile-card h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #059669;
            border: 1px solid #059669;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #dc2626;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #374151;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .form-group input:disabled {
            background-color: #f3f4f6;
            cursor: not-allowed;
        }

        /* Password Toggle */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 18px;
        }

        .toggle-password:hover {
            color: #495057;
        }

        /* Divider */
        .divider {
            margin: 30px 0;
            border: none;
            border-top: 1px solid #e2e8f0;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #475569;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Standardized Header Styles */
        .header {
            background-color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header-title {
            font-size: 14px;
            color: #64748b;
        }

        .header h1 {
            /* Resetting previously specific h1 */
            all: unset;
            font-size: 24px;
            font-weight: 600; 
            color: #1e293b;
        }

        .header-icons {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .icon-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #3b82f6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
        }

        .icon-btn:hover {
            background-color: #2563eb;
        }

        .icon-btn.notification::after {
            display: none;
        }

        /* Notification Styles */
        .notification-wrapper {
            position: relative;
            display: inline-block;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        .notification-dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            width: 320px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            z-index: 1000;
            border: 1px solid #e2e8f0;
            margin-top: 10px;
            overflow: hidden;
        }

        .notification-dropdown.active {
            display: block;
        }

        .notification-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
            color: #0f172a;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
        }

        .notification-list {
            max-height: 350px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s;
            cursor: pointer;
            display: block;
            text-decoration: none;
            position: relative;
        }

        .notification-item:hover {
            background-color: #f8fafc;
        }

        .notification-list::-webkit-scrollbar {
            width: 6px;
        }
        
        .notification-list::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .notification-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        
        .notification-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .notification-item.unread {
            background-color: #eff6ff;
            border-left: 3px solid #3b82f6;
        }
        
        .notification-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .notification-message {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 6px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-time {
            font-size: 11px;
            color: #94a3b8;
        }
        
        .empty-notification {
            padding: 30px;
            text-align: center;
            color: #94a3b8;
        }
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
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
            }

            .header {
                padding: 15px 15px 15px 65px;
            }

            .profile-content {
                padding: 20px 15px;
            }

            .form-grid {
                grid-template-columns: 1fr !important;
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
            <div class="admin-profile">
                <div class="admin-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="admin-name">{{ session('admin.name', 'Administrator') }}</div>
                <div class="admin-role">Status:<br>Admin</div>
            </div>

            <div class="menu">
                <a href="/dashboard-admin" class="menu-item">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
                <a href="/data-pengguna" class="menu-item">
                    <i class="fas fa-users"></i>
                    <span>Data Pengguna</span>
                </a>
                <a href="/data-kos" class="menu-item">
                    <i class="fas fa-database"></i>
                    <span>Data Kos</span>
                </a>
                <a href="/transaksi" class="menu-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Transaksi</span>
                </a>
                <a href="/keluhan" class="menu-item">
                    <i class="fas fa-comments"></i>
                    <span>Feedback Aplikasi</span>
                </a>
                <a href="/laporan" class="menu-item">
                    <i class="fas fa-file-alt"></i>
                    <span>Laporan</span>
                </a>
                <a href="/profil-admin" class="menu-item active">
                    <i class="fas fa-user-circle"></i>
                    <span>Profil</span>
                </a>
            </div>

            <form method="POST" action="/logout-admin" style="display: inline;">
                @csrf
                <button type="button" class="logout-btn" onclick="confirmLogout(this.form)">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

        <div class="main-content">
            <div class="header">
                 <div class="header-title">
                    <h1>Profil Admin</h1>
                </div>
                <div class="header-icons">
                    <a href="/profil-admin" class="icon-btn" style="text-decoration: none;">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="notification-wrapper">
                        <button class="icon-btn notification" id="notificationBtn" onclick="toggleNotifications()" style="border: none;">
                            <i class="fas fa-bell"></i>
                            @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                                <span class="notification-badge">{{ $unreadNotificationsCount }}</span>
                            @endif
                        </button>
                        <div class="notification-dropdown" id="notificationDropdown">
                            <div class="notification-header">
                                <span>Notifikasi</span>
                                <small>{{ $unreadNotificationsCount ?? 0 }} Baru</small>
                            </div>
                            <div class="notification-list">
                                @if(isset($notifications) && count($notifications) > 0)
                                    @foreach($notifications as $notif)
                                        <a href="{{ $notif->link ?? '#' }}" class="notification-item {{ !$notif->is_read ? 'unread' : '' }}">
                                            <div class="notification-title">{{ $notif->judul }}</div>
                                            <div class="notification-message">{{ $notif->pesan }}</div>
                                            <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="empty-notification">
                                        Tidak ada notifikasi
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-content">
                <h1 class="page-title">Pengaturan Profil</h1>

                <div class="profile-card">
                    <h3>
                        <i class="fas fa-user-cog"></i>
                        Informasi Profil
                    </h3>

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="/update-profil-admin" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama-lengkap">
                                <i class="fas fa-user"></i> Nama Lengkap
                            </label>
                            <input type="text" id="nama-lengkap" name="nama-lengkap" 
                                   value="{{ session('admin.name', 'Administrator') }}" required>
                            @error('nama-lengkap')
                                <small style="color: #dc2626;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email" id="email" name="email" 
                                   value="{{ session('admin.email', 'admin@kosconnect.com') }}" required>
                            @error('email')
                                <small style="color: #dc2626;">{{ $message }}</small>
                            @enderror
                        </div>

                        <hr class="divider">

                        <h4 class="section-title">
                            <i class="fas fa-lock"></i> Ubah Password (Opsional)
                        </h4>

                        <div class="form-group">
                            <label for="password-lama">Password Lama</label>
                            <div class="password-wrapper">
                                <input type="password" id="password-lama" name="password-lama" 
                                       placeholder="Kosongkan jika tidak ingin mengubah password">
                                <i class="fas fa-eye toggle-password" onclick="togglePassword('password-lama')"></i>
                            </div>
                            @error('password-lama')
                                <small style="color: #dc2626;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-baru">Password Baru</label>
                            <div class="password-wrapper">
                                <input type="password" id="password-baru" name="password-baru" 
                                       placeholder="Minimal 6 karakter">
                                <i class="fas fa-eye toggle-password" onclick="togglePassword('password-baru')"></i>
                            </div>
                            @error('password-baru')
                                <small style="color: #dc2626;">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-konfirmasi">Konfirmasi Password Baru</label>
                            <div class="password-wrapper">
                                <input type="password" id="password-konfirmasi" name="password-konfirmasi" 
                                       placeholder="Ulangi password baru">
                                <i class="fas fa-eye toggle-password" onclick="togglePassword('password-konfirmasi')"></i>
                            </div>
                            @error('password-konfirmasi')
                                <small style="color: #dc2626;">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            const icon = input.nextElementSibling;
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
    @include('components.sweetalert')
    <script>
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('active');
        }

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
