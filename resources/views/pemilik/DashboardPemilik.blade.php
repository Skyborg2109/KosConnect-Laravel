<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="{{ asset('images/logo-kosconnect.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik - KosConnect</title>
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .pemilik-avatar:hover {
            transform: scale(1.05);
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
            padding-left: 25px; /* Subtle indent effect */
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
            /* Remove static dot, we use badge now */
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
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
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

        .mobile-recent-list {
            display: none;
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

        /* Mobile Responsive Styles */
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

            .dashboard-content {
                padding: 20px 15px;
            }

            .page-title {
                font-size: 20px;
                margin-bottom: 15px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .stat-card {
                padding: 15px 12px;
                gap: 12px;
                flex-direction: column;
                align-items: flex-start;
                justify-content: center;
            }

            .stat-info h3 {
                font-size: 18px;
                line-height: 1.2;
                word-break: break-all;
            }

            .stat-info p {
                font-size: 11px;
                white-space: nowrap;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .table-section table {
                display: none;
            }

            .mobile-recent-list {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .recent-activity-card {
                background: white;
                border-radius: 12px;
                padding: 15px;
                border: 1px solid #e2e8f0;
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .activity-card-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
            }

            .user-info {
                display: flex;
                flex-direction: column;
            }

            .user-name {
                font-weight: 600;
                color: #1e293b;
                font-size: 14px;
            }

            .activity-date {
                font-size: 11px;
                color: #64748b;
            }

            .activity-card-body {
                background: #f8fafc;
                padding: 10px;
                border-radius: 8px;
            }

            .kos-name {
                font-size: 13px;
                font-weight: 600;
                color: #334155;
                display: block;
                margin-bottom: 2px;
            }

            .kamar-name {
                font-size: 12px;
                color: #64748b;
            }

            .activity-card-footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 5px;
            }

            .activity-price {
                font-weight: 700;
                color: #1e293b;
                font-size: 14px;
            }

            .header-icons {
                gap: 8px;
            }

            .icon-btn {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .notification-dropdown {
                width: calc(100vw - 30px);
                max-width: 320px;
                right: -10px;
            }
        }

        @media (max-width: 480px) {
            .header-title h1 {
                font-size: 15px;
                max-width: 120px;
            }

            .dashboard-content {
                padding: 15px 10px;
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
                <a href="/dashboard-pemilik" class="menu-item active">
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
                    <h1>Dashboard Pemilik</h1></div>
                <div class="header-icons">
                    <form method="GET" action="/profil-pemilik" style="display: inline;">
                        @csrf
                        <button type="submit" class="icon-btn">
                            <i class="fas fa-user"></i>
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

            <!-- Dashboard Content -->
            <div class="dashboard-content">


                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalKos }}</h3>
                            <p>Total Kos</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $totalKamar }}</h3>
                            <p>Total Kamar</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $bookingAktif }}</h3>
                            <p>Booking Aktif</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon indigo">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $keluhanBaru }}</h3>
                            <p>Keluhan Terbaru</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon indigo">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h3>
                            <p>Pendapatan Bulan Ini</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon indigo">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $ratingRataRata }}</h3>
                            <p>Rating Kos</p>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-section">
                    <h2 class="table-title">5 Pesanan Terakhir</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>NAMA PENYEWA</th>
                                <th>KAMAR</th>
                                <th>TOTAL HARGA</th>
                                <th>TANGGAL</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $b)
                            <tr>
                                <td>{{ $b->penyewa->nama_user ?? 'Nama Tidak Tersedia' }}</td>
                                <td>
                                    {{ $b->kamar->kos->nama_kos ?? '-' }} <br>
                                    <small style="color: #64748b;">(Kamar {{ $b->kamar->nomor_kamar ?? '-' }})</small>
                                </td>
                                <td>Rp {{ number_format($b->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $b->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if($b->status == 'menunggu_konfirmasi')
                                        <span class="status-badge" style="background-color: #dbeafe; color: #1e40af;">Perlu Konfirmasi</span>
                                    @elseif($b->status == 'menunggu_pembayaran')
                                        <span class="status-badge" style="background-color: #fef08a; color: #854d0e;">Menunggu Bayar</span>
                                    @elseif($b->status == 'verifikasi_pembayaran')
                                        <span class="status-badge" style="background-color: #e0f2fe; color: #0369a1;">Verifikasi Bayar</span>
                                    @elseif($b->status == 'aktif')
                                        <span class="status-badge selesai">Aktif</span>
                                    @elseif($b->status == 'selesai')
                                        <span class="status-badge" style="background-color: #f3f4f6; color: #374151;">Selesai</span>
                                    @elseif($b->status == 'ditolak')
                                        <span class="status-badge" style="background-color: #fca5a5; color: #991b1b;">Ditolak</span>
                                    @elseif($b->status == 'dibatalkan')
                                        <span class="status-badge" style="background-color: #f3f4f6; color: #374151;">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px;">
                                    <i class="fas fa-inbox" style="font-size: 24px; color: #cbd5e1; margin-bottom: 10px;"></i>
                                    <p style="color: #64748b;">Belum ada aktivitas pesanan terbaru</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Mobile View Activity List -->
                    <div class="mobile-recent-list">
                        @forelse($recentBookings as $b)
                        <div class="recent-activity-card">
                            <div class="activity-card-header">
                                <div class="user-info">
                                    <span class="user-name">{{ $b->penyewa->nama_user ?? 'Nama Tidak Tersedia' }}</span>
                                    <span class="activity-date">{{ $b->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                @if($b->status == 'menunggu_konfirmasi')
                                    <span class="status-badge" style="background-color: #dbeafe; color: #1e40af;">Perlu Konfirmasi</span>
                                @elseif($b->status == 'menunggu_pembayaran')
                                    <span class="status-badge" style="background-color: #fef08a; color: #854d0e;">Menunggu Bayar</span>
                                @elseif($b->status == 'verifikasi_pembayaran')
                                    <span class="status-badge" style="background-color: #e0f2fe; color: #0369a1;">Verifikasi Bayar</span>
                                @elseif($b->status == 'aktif')
                                    <span class="status-badge selesai">Aktif</span>
                                @elseif($b->status == 'selesai')
                                    <span class="status-badge" style="background-color: #f3f4f6; color: #374151;">Selesai</span>
                                @elseif($b->status == 'ditolak')
                                    <span class="status-badge" style="background-color: #fca5a5; color: #991b1b;">Ditolak</span>
                                @elseif($b->status == 'dibatalkan')
                                    <span class="status-badge" style="background-color: #f3f4f6; color: #374151;">Dibatalkan</span>
                                @endif
                            </div>
                            <div class="activity-card-body">
                                <span class="kos-name">{{ $b->kamar->kos->nama_kos ?? '-' }}</span>
                                <span class="kamar-name">Kamar {{ $b->kamar->nomor_kamar ?? '-' }}</span>
                            </div>
                            <div class="activity-card-footer">
                                <span class="activity-price">Rp {{ number_format($b->total_harga, 0, ',', '.') }}</span>
                                <a href="/pemilik/kelola-pesanan" style="font-size: 12px; color: #3b82f6; text-decoration: none; font-weight: 500;">Detail Pesanan <i class="fas fa-chevron-right" style="font-size: 10px;"></i></a>
                            </div>
                        </div>
                        @empty
                        <div style="text-align: center; padding: 20px;">
                            <p style="color: #64748b;">Belum ada aktivitas pesanan terbaru</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('components.sweetalert')

    <script>
        // Auto-refresh page every 60 seconds to keep data realtime
        setTimeout(function() {
            window.location.reload();
        }, 60000);
    </script>
    <script>
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
</body>
</html>
