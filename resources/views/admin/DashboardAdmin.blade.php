<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="{{ asset('images/logo-kosconnect.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - KosConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            transition: transform 0.3s ease;
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
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background: #2563eb;
            transform: scale(1.05);
        }

        .mobile-menu-toggle i {
            font-size: 20px;
        }

        /* Mobile Overlay */
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
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .admin-avatar:hover {
            transform: scale(1.05);
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
            transition: background-color 0.3s;
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

        /* Custom Scrollbar */
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

        /* Dashboard Content */
        .dashboard-content {
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

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            background-color: #1e293b;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px 10px 0 0;
        }

        .modal-header h2 {
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
        }

        .close-btn:hover {
            opacity: 0.7;
        }

        .modal-body {
            padding: 30px;
        }

        /* Ganti Foto Profil Section */
        .photo-section {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px 25px;
            border-bottom: 1px solid #e2e8f0;
        }

        .photo-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #1e293b;
        }

        .avatar-placeholder {
            width: 130px;
            height: 130px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: white;
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .avatar-placeholder:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
        }

        .file-input-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .file-input {
            padding: 10px 20px;
            border: 2px solid #667eea;
            border-radius: 8px;
            background-color: white;
            color: #667eea;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .file-input:hover {
            background-color: #667eea;
            color: white;
        }

        .file-text {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .upload-btn {
            padding: 12px 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .upload-btn:active {
            transform: translateY(0);
        }

        /* Settings Section */
        .settings-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .panel {
            background-color: #f8fafc;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .panel h4 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1e293b;
        }

        .form-group {
            margin-bottom: 20px;
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

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .action-btn {
            width: 100%;
            padding: 12px;
            background-color: #475569;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .action-btn:hover {
            background-color: #334155;
        }

        @media (max-width: 768px) {
            .settings-section {
                grid-template-columns: 1fr;
            }

            .modal-body {
                padding: 20px;
            }
        }

        /* Dashboard Content */
        .dashboard-content {
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

        /* Mobile Responsive Styles */
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

            .header-title h1 {
                font-size: 18px;
            }

            .dashboard-content {
                padding: 20px 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr !important;
                gap: 15px;
            }

            .page-title {
                font-size: 22px;
            }

            .table-section {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table {
                min-width: 600px;
            }

            .header-icons {
                gap: 10px;
            }

            .icon-btn {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .header {
                padding: 12px 12px 12px 60px;
            }

            .header-title h1 {
                font-size: 16px;
            }

            .dashboard-content {
                padding: 15px 10px;
            }

            .page-title {
                font-size: 20px;
                margin-bottom: 20px;
            }

            .stat-card {
                padding: 15px;
            }

            .stat-value {
                font-size: 24px;
            }

            .stat-label {
                font-size: 12px;
            }
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.blue {
            background-color: #3b82f6;
        }

        .stat-icon.indigo {
            background-color: #6366f1;
        }

        .stat-info h3 {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .stat-info p {
            font-size: 14px;
            color: #64748b;
        }

        /* Table Section */
        .table-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
        }

        .table-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f8fafc;
        }

        th {
            padding: 15px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px;
            border-top: 1px solid #e2e8f0;
            color: #1e293b;
            transition: all 0.3s ease;
        }

        tbody tr {
            /* No animation */
        }
        tbody tr:nth-child(4) { animation-delay: 1.4s; }
        tbody tr:nth-child(5) { animation-delay: 1.6s; }

        @keyframes tableRowFadeIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .status-badge.menunggu {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-badge.selesai {
            background-color: #dcfce7;
            color: #166534;
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Toggle Menu">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" onclick="toggleMobileMenu()"></div>

    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="admin-profile">
                <div class="admin-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="admin-name">Administrator</div>
                <div class="admin-role">Status:<br>Admin</div>
            </div>

            <div class="menu">
                <a href="#" class="menu-item active">
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
                <a href="/profil-admin" class="menu-item">
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

       <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="header-title">
                    <h1>Dashboard Admin</h1></div>
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
            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <h1 class="page-title">Selamat datang USER {{ session('admin.name') }}</h1>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalUsers ?? 0 }}</h3>
                            <p>Total Pengguna</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalPemilik ?? 0 }}</h3>
                            <p>Total Pemilik Kos</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalPenyewa ?? 0 }}</h3>
                            <p>Total Penyewa</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon indigo">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalKos ?? 0 }}</h3>
                            <p>Total Properti Kos</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon indigo">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalBookingAktif ?? 0 }}</h3>
                            <p>Booking Aktif</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon indigo">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalKeluhan ?? 0 }}</h3>
                            <p>Keluhan Terbaru</p>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-section">
                    <h2 class="table-title">5 Transaksi Pembayaran Terbaru</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>NAMA PENYEWA</th>
                                <th>JUMLAH</th>
                                <th>TANGGAL</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions ?? [] as $transaction)
                            <tr>
                                <td>{{ $transaction->penyewa->nama_user ?? 'N/A' }}</td>
                                <td>Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($transaction->status == 'menunggu_konfirmasi')
                                        <span class="status-badge menunggu">Menunggu</span>
                                    @elseif($transaction->status == 'aktif')
                                        <span class="status-badge selesai">Aktif</span>
                                    @else
                                        <span class="status-badge">{{ ucfirst($transaction->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #64748b;">Tidak ada transaksi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->
    <div id="profileModal" class="modal-overlay" style="display: none;">
        <div class="modal">
            <!-- Modal Header -->
            <div class="modal-header">
                <h2>
                    <i class="fas fa-user"></i>
                    Profil Saya
                </h2>
                <button class="close-btn" onclick="closeProfileModal()">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Ganti Foto Profil -->
                <div class="photo-section">
                    <h3>
                        <i class="fas fa-camera"></i>
                        Ganti Foto Profil
                    </h3>
                    <div class="avatar-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="file-input-group">
                        <input type="file" id="photo-input" style="display: none;">
                        <label for="photo-input" class="file-input">Choose file</label>
                        <span class="file-text">No file chosen</span>
                    </div>
                    <button class="upload-btn">
                        <i class="fas fa-upload"></i>
                        Unggah
                    </button>
                </div>

                <!-- Settings -->
                <div class="settings-section">
                    <!-- Panel Kiri: Informasi Pribadi -->
                    <div class="panel">
                        <h4>
                            <i class="fas fa-user"></i>
                            Informasi Pribadi
                        </h4>
                        <form>
                            <div class="form-group">
                                <label for="nama-lengkap">
                                    <i class="fas fa-lock-open"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" id="nama-lengkap" value="Administrator">
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-lock-open"></i>
                                    Email
                                </label>
                                <input type="email" id="email" placeholder="Masukkan email">
                            </div>
                            <button type="submit" class="action-btn">
                                <i class="fas fa-lock-open"></i>
                                Simpan Nama
                            </button>
                        </form>
                    </div>

                    <!-- Panel Kanan: Ubah Password -->
                    <div class="panel">
                        <h4>
                            <i class="fas fa-lock"></i>
                            Ubah Password
                        </h4>
                        <form>
                            <div class="form-group">
                                <label for="password-lama">
                                    <i class="fas fa-lock"></i>
                                    Password Lama
                                </label>
                                <input type="password" id="password-lama">
                            </div>
                            <div class="form-group">
                                <label for="password-baru">
                                    <i class="fas fa-lock"></i>
                                    Password Baru
                                </label>
                                <input type="password" id="password-baru">
                            </div>
                            <div class="form-group">
                                <label for="konfirmasi-password">
                                    <i class="fas fa-lock"></i>
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" id="konfirmasi-password">
                            </div>
                            <button type="submit" class="action-btn">
                                <i class="fas fa-lock"></i>
                                Ubah Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('components.sweetalert')
    <script>
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            const badge = document.querySelector('.notification-badge');
            
            if (!dropdown.classList.contains('active')) {
                // Opening menu, mark as read
                fetch('/admin/notifications/read-all', {
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

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Close mobile menu when clicking menu items
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
