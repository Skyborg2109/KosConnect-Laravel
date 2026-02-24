<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - KosConnect</title>
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
            transition: background-color 0.3s ease;
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
            margin-bottom: 30px;
            margin-bottom: 30px;
            color: #1e293b;
        }

        /* Notifications */
        .notifications-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            position: relative;
        }

        .notifications-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f59e0b, #ef4444, #8b5cf6);
            transform: scaleX(0);
            transform-origin: left;
            background: linear-gradient(90deg, #f59e0b, #ef4444, #8b5cf6);
            transform: scaleX(1);
            transform-origin: left;
        }

        .notification-item {
            padding: 20px 30px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            gap: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .notification-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #3b82f6, #06b6d4);
            transform: scaleY(0);
            transform-origin: top;
            transition: transform 0.3s ease;
        }

        .notification-item:hover::before {
            transform: scaleY(1);
        }

        .notification-item:hover {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-icon.info {
            background-color: #dbeafe;
            color: #2563eb;
        }

        .notification-icon.success {
            background-color: #dcfce7;
            color: #16a34a;
        }

        .notification-icon.warning {
            background-color: #fef3c7;
            color: #d97706;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .notification-message {
            color: #64748b;
            font-size: 14px;
        }

        .notification-time {
            color: #94a3b8;
            font-size: 12px;
            margin-top: 5px;
        }

        .notification-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #f1f5f9;
            color: #64748b;
        }

        .btn-secondary:hover {
            background-color: #e2e8f0;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
        }

        .empty-state h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 14px;
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

            .notification-item {
                padding: 15px;
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
                    <h1>Notifikasi</h1>
                </div>
                <div class="header-icons">
                    <form method="GET" action="/profil-pemilik" style="display: inline;">
                        @csrf
                        <button type="submit" class="icon-btn">
                            <i class="fas fa-user"></i>
                        </button>
                    </form>
                    <div class="icon-btn notification active">
                        <i class="fas fa-bell"></i>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">


                <div class="notifications-container">
                    <!-- Sample notifications - replace with dynamic data -->
                    <div class="notification-item">
                        <div class="notification-icon info">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">Pesanan Baru Masuk</div>
                            <div class="notification-message">Ada pesanan baru untuk Kos Melati dari penyewa baru.</div>
                            <div class="notification-time">2 jam yang lalu</div>
                        </div>
                        <div class="notification-actions">
                            <form method="GET" action="/pemilik/verifikasi-pembayaran" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary">Lihat Detail</button>
                            </form>
                        </div>
                    </div>

                    <div class="notification-item">
                        <div class="notification-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">Pembayaran Dikonfirmasi</div>
                            <div class="notification-message">Pembayaran untuk Kos Mawar telah berhasil dikonfirmasi.</div>
                            <div class="notification-time">1 hari yang lalu</div>
                        </div>
                        <div class="notification-actions">
                            <form method="GET" action="#" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Tandai Dibaca</button>
                            </form>
                        </div>
                    </div>

                    <div class="notification-item">
                        <div class="notification-icon warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">Keluhan Baru</div>
                            <div class="notification-message">Ada keluhan baru mengenai fasilitas di Kos Anggrek.</div>
                            <div class="notification-time">3 hari yang lalu</div>
                        </div>
                        <div class="notification-actions">
                            <form method="GET" action="/pemilik/keluhan-kos" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary">Tanggapi</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Empty state (uncomment when no notifications) -->
                <!-- <div class="notifications-container">
                    <div class="empty-state">
                        <i class="fas fa-bell-slash"></i>
                        <h3>Tidak Ada Notifikasi</h3>
                        <p>Anda belum memiliki notifikasi baru saat ini.</p>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
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
    @include('components.sweetalert')
</body>
</html>