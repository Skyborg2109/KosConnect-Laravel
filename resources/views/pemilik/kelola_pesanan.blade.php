<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan Masuk - KosConnect</title>
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
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
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

        /* Notification Styles */
        .notification-wrapper {
            position: relative;
            margin-right: 15px;
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
            transition: background-color 0.3s ease;
        }

        .icon-btn:hover {
            background-color: #2563eb;
        }



        /* Dashboard Content */
        .dashboard-content {
            flex: 1;
            padding: 30px;
            padding: 30px;
            overflow-y: auto;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #1e293b;
        }

        /* Filter Section */
        .filter-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .filter-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f59e0b, #ef4444, #8b5cf6);
            transform: scaleX(0);
            transform-origin: left;
        }

        .filter-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }

        .filter-tabs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 10px 20px;
            border: 1px solid #e2e8f0;
            background-color: white;
            color: #64748b;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .filter-tab.active {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .filter-tab:hover {
            background-color: #f1f5f9;
        }

        /* Orders List */
        .orders-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
        }

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .order-item {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            position: relative; /* For absolute badge positioning */
        }

        .order-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-color: #3b82f6;
        }

        .order-item.paid {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-color: #bbf7d0;
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.1);
        }

        .order-details {
            flex: 1;
        }

        .order-name {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .order-info {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 5px;
        }

        .order-price {
            font-size: 16px;
            font-weight: 600;
            color: #7c3aed;
        }

        .order-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge.confirm {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-badge.paid {
            background-color: #dcfce7;
            color: #166534;
        }

        .btn-confirm {
            padding: 10px 20px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-confirm:hover {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-reject {
            padding: 10px 20px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-reject:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }

        /* Absolute positioned badge for top right */
        .status-badge-corner {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            background-color: #dbeafe;
            color: #1e40af;
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
                margin-left: 0;
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

            .filter-tabs {
                gap: 8px;
            }

            .filter-tab {
                padding: 8px 12px;
                font-size: 13px;
                flex: 1 1 auto;
                text-align: center;
            }

            .order-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .order-details {
                width: 100%;
            }

            .order-actions {
                width: 100%;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            .status-badge-corner {
                position: static;
                display: inline-block;
                margin-bottom: 10px;
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
                <a href="/pemilik/kelola-pesanan" class="menu-item active">
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
                    <h1>Kelola Pesanan</h1></div>
                <div class="header-icons">
                    <form method="GET" action="/profil-pemilik" style="display: inline;">
                        @csrf
                        <button type="submit" class="icon-btn">
                            <i class="fas fa-user"></i>
                        </button>
                    </form>
                    <!-- Static bell icon replaced with dynamic notification wrapper -->
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


                <!-- Filter Section -->
                <div class="filter-section">
                    <h2 class="filter-title">Daftar Pesanan (4)</h2>
                    <div class="filter-tabs">
                        <form method="GET" action="/pemilik/kelola-pesanan" style="display: inline;">
                            <input type="hidden" name="filter" value="baru">
                            <button type="submit" class="filter-tab {{ (isset($filter) && $filter == 'baru') ? 'active' : '' }}">Baru Masuk</button>
                        </form>
                        <form method="GET" action="/pemilik/kelola-pesanan" style="display: inline;">
                            <input type="hidden" name="filter" value="dikonfirmasi">
                            <button type="submit" class="filter-tab {{ (isset($filter) && $filter == 'dikonfirmasi') ? 'active' : '' }}">Dikonfirmasi</button>
                        </form>
                        <form method="GET" action="/pemilik/kelola-pesanan" style="display: inline;">
                            <input type="hidden" name="filter" value="dibayar">
                            <button type="submit" class="filter-tab {{ (isset($filter) && $filter == 'dibayar') ? 'active' : '' }}">Dibayar</button>
                        </form>
                        <form method="GET" action="/pemilik/kelola-pesanan" style="display: inline;">
                            <input type="hidden" name="filter" value="ditolak">
                            <button type="submit" class="filter-tab {{ (isset($filter) && $filter == 'ditolak') ? 'active' : '' }}">Ditolak</button>
                        </form>
                        <form method="GET" action="/pemilik/kelola-pesanan" style="display: inline;">
                            <input type="hidden" name="filter" value="dibatalkan">
                            <button type="submit" class="filter-tab {{ (isset($filter) && $filter == 'dibatalkan') ? 'active' : '' }}">Dibatalkan</button>
                        </form>
                        <form method="GET" action="/pemilik/kelola-pesanan" style="display: inline;">
                            <input type="hidden" name="filter" value="semua">
                            <button type="submit" class="filter-tab {{ (!isset($filter) || $filter == 'semua') ? 'active' : '' }}">Semua</button>
                        </form>
                    </div>
                </div>

                <!-- Orders Section -->
                <div class="orders-section">
                    <div class="orders-list">
                        @forelse($bookings as $booking)
                        <div class="order-item {{ $booking->status == 'aktif' ? 'paid' : '' }}">
                            <div class="order-details">
                                <div class="order-name">{{ $booking->penyewa->nama_user ?? 'Nama Tidak Tersedia' }}</div>
                                <div class="order-info">
                                    {{ $booking->kamar->kos->nama_kos ?? 'Kos' }} - {{ $booking->kamar->nomor_kamar ?? 'Kamar' }}
                                    ({{ $booking->kamar->tipe_kamar ?? 'Tipe' }})
                                </div>
                                <div class="order-info">Tanggal: {{ $booking->created_at->format('d M Y') }}</div>
                                <div class="order-price">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                            </div>
                            <div class="order-actions">
                                @if($booking->status == 'menunggu_konfirmasi')
                                    <span class="status-badge-corner">Perlu Konfirmasi</span>
                                    <form method="POST" action="/pemilik/tolak-pesanan/{{ $booking->id }}" style="display: inline;" id="tolakForm{{ $booking->id }}">
                                        @csrf
                                        <button type="button" class="btn-reject" onclick="confirmOrderAction('tolak', {{ $booking->id }})">TOLAK</button>
                                    </form>
                                    <form method="POST" action="/pemilik/konfirmasi-pesanan/{{ $booking->id }}" style="display: inline;" id="konfirmasiForm{{ $booking->id }}">
                                        @csrf
                                        <button type="button" class="btn-confirm" onclick="confirmOrderAction('konfirmasi', {{ $booking->id }})">KONFIRMASI</button>
                                    </form>
                                @elseif($booking->status == 'menunggu_pembayaran')
                                    <span class="status-badge" style="background-color: #fef08a; color: #854d0e;">Menunggu Pembayaran</span>
                                @elseif($booking->status == 'verifikasi_pembayaran')
                                    <span class="status-badge" style="background-color: #bbf7d0; color: #166534;">Verifikasi Pembayaran</span>
                                    {{-- Optional: Link to verification page --}}
                                    <a href="/pemilik/verifikasi-pembayaran" class="btn-confirm" style="background: #10b981; text-decoration: none;">Lihat</a>
                                @elseif($booking->status == 'aktif')
                                    <span class="status-badge paid">Aktif</span>
                                @elseif($booking->status == 'ditolak')
                                    <span class="status-badge" style="background-color: #fca5a5; color: #991b1b;">Ditolak</span>
                                @elseif($booking->status == 'dibatalkan')
                                    <span class="status-badge" style="background-color: #e5e7eb; color: #374151;">Dibatalkan</span>
                                @else
                                    <span class="status-badge">{{ ucfirst(str_replace('_', ' ', $booking->status)) }}</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="empty-state" style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;"></i>
                            <p>Tidak ada pesanan ditemukan pada filter ini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    
    @include('components.sweetalert')
    <script>
        function confirmOrderAction(type, id) {
            let title, text, confirmBtnText, confirmBtnColor, formId;
            
            if (type === 'tolak') {
                title = 'Tolak Pesanan?';
                text = "Apakah Anda yakin ingin menolak pesanan ini?";
                confirmBtnText = 'Ya, Tolak!';
                confirmBtnColor = '#ef4444';
                formId = 'tolakForm' + id;
            } else {
                title = 'Konfirmasi Pesanan?';
                text = "Apakah Anda yakin ingin mengkonfirmasi pesanan ini? Status akan berubah menjadi Menunggu Pembayaran.";
                confirmBtnText = 'Ya, Konfirmasi!';
                confirmBtnColor = '#3b82f6';
                formId = 'konfirmasiForm' + id;
            }

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: confirmBtnColor,
                cancelButtonColor: '#64748b',
                confirmButtonText: confirmBtnText,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
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
</body>
</html>
