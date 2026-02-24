<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - KosConnect</title>
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

        .pemilik-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: all 0.3s ease;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

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
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding-left: 25px;
        }

        .menu-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            border-left: none;
        }

        .menu-item i {
            margin-right: 25px;
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
            background-color: #e2e8f0;
        }

        .icon-btn.active {
            background-color: #3b82f6;
            color: white;
        }

        .icon-btn.active:hover {
            background-color: #2563eb;
        }

        /* Notification Styles */
        .notification-wrapper {
            position: relative;
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
            font-weight: 600;
        }

        .notification-dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            width: 320px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            z-index: 1000;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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
            background: #f8fafc;
        }

        .notification-list {
            max-height: 350px;
            overflow-y: auto;
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

        .notification-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s;
            cursor: pointer;
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .notification-item:hover {
            background-color: #f8fafc;
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
        }

        .notification-time {
            font-size: 11px;
            color: #94a3b8;
        }

        .empty-notification {
            padding: 40px 20px;
            text-align: center;
            color: #94a3b8;
            font-size: 14px;
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
            margin-bottom: 30px;
            color: #1e293b;
        }

        /* Profile Content */
        .profile-container {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 30px;
            max-width: 1400px;
        }

        .profile-panel {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.06);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .profile-panel:hover::before {
            transform: scaleX(1);
        }

        .profile-panel:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.15);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .panel-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1e293b;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }

        .panel-title i {
            color: #667eea;
            font-size: 24px;
        }

        .photo-section {
            text-align: center;
            margin-bottom: 0;
            padding: 30px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            position: relative;
            overflow: hidden;
        }

        .photo-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .photo-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 30px;
            color: white;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .avatar-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 30px;
            z-index: 1;
        }

        .camera-icon-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            z-index: 2;
        }

        .camera-icon-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .camera-icon-btn i {
            color: white;
            font-size: 18px;
        }

        .avatar-large {
            width: 150px;
            height: 150px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            color: #667eea;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            border: 5px solid rgba(255,255,255,0.9);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .avatar-large:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
        }

        .avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .avatar-large.has-image img {
            display: block;
        }

        .avatar-large.has-image i {
            display: none;
        }



        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s ease;
        }

        .form-group label i {
            color: #667eea;
            font-size: 16px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8fafc;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .form-group input::placeholder {
            color: #94a3b8;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn i {
            position: relative;
            z-index: 1;
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }

        .file-input-wrapper {
            position: relative;
            margin: 0;
            z-index: 1;
            text-align: center;
        }

        .file-input-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 32px;
            background: white;
            color: #667eea;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .file-input-label:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .file-input-label i {
            font-size: 16px;
        }

        .file-name {
            display: block;
            margin-top: 0;
            margin-bottom: 20px;
            color: white;
            font-size: 12px;
            font-weight: 500;
            text-shadow: 0 1px 3px rgba(0,0,0,0.2);
            min-height: 18px;
            opacity: 0.9;
        }

        .password-section {
            grid-column: 1 / -1;
        }

        .password-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        @media (max-width: 1024px) {
            .profile-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            
            .password-grid {
                grid-template-columns: 1fr;
            }
            
            .profile-panel {
                padding: 25px;
            }
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

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
                top: 12px;
                left: 12px;
                width: 40px;
                height: 40px;
            }

            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
                z-index: 1005;
                width: 280px;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                width: 100%;
            }

            .header {
                padding: 12px 15px 12px 65px;
                height: 64px;
            }

            .header-title h1 {
                font-size: 16px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 150px;
            }

            .content {
                padding: 20px 15px;
            }

            .page-title {
                font-size: 20px;
            }

            .profile-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .header-icons {
                gap: 8px;
            }

            .icon-btn {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .header-title h1 {
                font-size: 15px;
                max-width: 120px;
            }

            .content {
                padding: 15px 10px;
            }

            .profile-panel {
                padding: 20px;
            }

            .avatar-large {
                width: 120px;
                height: 120px;
            }

            .avatar-container {
                width: 120px;
                height: 120px;
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
                <div class="pemilik-avatar" style="overflow: hidden;">
                    @if(session('user.foto_profil'))
                        <img src="{{ session('user.foto_profil') }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                </div>
                <div class="pemilik-name">Pemilik Kos</div>
                <div class="pemilik-role">Status:<br>Pemilik</div>
            </div>

            <div class="menu">
                <a href="/dashboard-pemilik" class="menu-item">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>

                <a href="/pemilik/manajemen-kos" class="menu-item">
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
                    <i class="fas fa-comments"></i>
                    <span>Keluhan Kos</span>
                </a>



                <a href="/profil-pemilik" class="menu-item active">
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
                    <h1>Profil Saya</h1>
                </div>
                <div class="header-icons">
                    <form method="GET" action="#" style="display: inline;">
                        @csrf
                        <button type="submit" class="icon-btn">
                            <i class="fas fa-bell"></i>
                        </button>
                    </form>
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

            <!-- Content -->
            <div class="content">


                @if(session('success'))
                    <div style="background-color: #d1fae5; color: #059669; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div style="background-color: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="profile-container">
                    <!-- Panel Kiri: Foto Profil -->
                    <div class="profile-panel">
                        <form method="POST" action="/update-photo" enctype="multipart/form-data" id="photoForm">
                            @csrf
                            <div class="photo-section">
                                <h2 class="photo-title">
                                    <i class="fas fa-camera"></i>
                                    Ganti Foto Profil
                                </h2>
                                <div class="avatar-container">
                                    <div class="avatar-large {{ session('user.foto_profil') ? 'has-image' : '' }}" id="avatarPreview">
                                        @if(session('user.foto_profil'))
                                            <img id="previewImage" src="{{ session('user.foto_profil') }}" alt="Profile Photo">
                                        @else
                                            <i class="fas fa-user"></i>
                                            <img id="previewImage" src="" alt="Preview">
                                        @endif
                                    </div>
                                    <label for="photo-input" class="camera-icon-btn">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                </div>
                                <div class="file-input-wrapper">
                                    <input type="file" id="photo-input" name="photo" style="display: none;" accept="image/*" onchange="previewPhoto(event)" required>
                                    <span class="file-name" id="fileName">Belum ada file dipilih</span>
                                    @error('photo')
                                        <div style="color: #dc2626; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload"></i>
                                    <span>Unggah Foto</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Panel Kanan: Informasi Pribadi -->
                    <div class="profile-panel">
                        <h2 class="panel-title">
                            <i class="fas fa-id-card"></i>
                            Informasi Pribadi
                        </h2>
                        <form method="POST" action="/update-profil-pemilik">
                            @csrf
                            <div class="form-group">
                                <label for="nama-lengkap">
                                    <i class="fas fa-user"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" id="nama-lengkap" name="nama-lengkap" value="{{ session('user.name', 'Pemilik') }}" placeholder="Masukkan nama lengkap" required>
                                @error('nama-lengkap')
                                    <small style="color: #dc2626;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i>
                                    Email
                                </label>
                                <input type="email" id="email" name="email" value="{{ session('user.email', '') }}" placeholder="contoh@email.com" required>
                                @error('email')
                                    <small style="color: #dc2626;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="telepon">
                                    <i class="fas fa-phone"></i>
                                    Nomor Telepon
                                </label>
                                <input type="text" id="telepon" name="telepon" value="{{ session('user.nomor_telepon', '') }}" placeholder="08xxxxxxxxxx">
                                @error('telepon')
                                    <small style="color: #dc2626;">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </form>
                    </div>

                    <!-- Panel Penuh: Ubah Password -->
                    <div class="profile-panel password-section">
                        <h2 class="panel-title">
                            <i class="fas fa-shield-alt"></i>
                            Ubah Password (Opsional)
                        </h2>
                        <div class="password-grid">
                            <div class="form-group">
                                <label for="password-lama">
                                    <i class="fas fa-key"></i>
                                    Password Lama
                                </label>
                                <input type="password" id="password-lama" name="password-lama" placeholder="Kosongkan jika tidak ingin mengubah">
                                @error('password-lama')
                                    <small style="color: #dc2626;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-baru">
                                    <i class="fas fa-lock"></i>
                                    Password Baru
                                </label>
                                <input type="password" id="password-baru" name="password-baru" placeholder="Minimal 6 karakter">
                                @error('password-baru')
                                    <small style="color: #dc2626;">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-konfirmasi">
                                    <i class="fas fa-check-circle"></i>
                                    Konfirmasi Password
                                </label>
                                <input type="password" id="password-konfirmasi" name="password-konfirmasi" placeholder="Ulangi password baru">
                                @error('password-konfirmasi')
                                    <small style="color: #dc2626;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            const fileName = document.getElementById('fileName');
            const avatarPreview = document.getElementById('avatarPreview');
            const previewImage = document.getElementById('previewImage');
            
            if (file) {
                fileName.textContent = file.name;
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    avatarPreview.classList.add('has-image');
                }
                reader.readAsDataURL(file);
            } else {
                fileName.textContent = 'Belum ada file dipilih';
                avatarPreview.classList.remove('has-image');
            }
        }

        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            const badge = document.querySelector('.notification-badge');
            
            if (!dropdown.classList.contains('active')) {
                // Opening menu, mark as read
                fetch('/pemilik/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        if (badge) badge.style.display = 'none';
                    }
                }).catch(error => console.error('Error marking notifications as read:', error));
            }
            
            dropdown.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const wrapper = document.querySelector('.notification-wrapper');
            const dropdown = document.getElementById('notificationDropdown');
            const btn = document.getElementById('notificationBtn');
            
            if (wrapper && !wrapper.contains(event.target) && event.target !== btn && !btn.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

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
    
    @include('components.sweetalert')
</body>
</html>
