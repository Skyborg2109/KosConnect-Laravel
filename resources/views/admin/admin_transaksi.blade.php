<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="{{ asset('images/logo-kosconnect.png?v=3') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - KosConnect</title>
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
            background-color: #1e293b;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .admin-profile {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid #334155;
        }

        .admin-avatar {
            width: 60px;
            height: 60px;
            background-color: #64748b;
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
            transition: all 0.3s;
            cursor: pointer;
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

        .mobile-menu-toggle:hover {
            background: #2563eb;
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

        /* Cards */
        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
        }

        .card-subtitle {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-warning:hover {
            background-color: #d97706;
        }

        .btn-filter {
            background-color: #3b82f6;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-filter:hover {
            background-color: #2563eb;
        }

        .card-content {
            padding: 25px;
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
        }

        .price-green {
            color: #166534;
            font-weight: 600;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .status-badge.dibayar {
            background-color: #dcfce7;
            color: #166534;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-verify {
            background: #10b981;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .btn-verify:hover {
            background: #059669;
        }

        .btn-reject {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .btn-reject:hover {
            background: #c82333;
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

            .header-title h1 {
                font-size: 18px;
            }

            .dashboard-content {
                padding: 20px 15px;
            }

            .page-title {
                font-size: 20px;
                margin-bottom: 15px;
            }

            .table-section {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                margin: 0 -15px;
                padding: 0 15px;
            }

            .table-title {
                font-size: 16px;
                margin-bottom: 15px;
            }

            table {
                width: 100%;
                font-size: 12px;
                table-layout: fixed;
            }

            table th,
            table td {
                padding: 10px 6px;
                word-wrap: break-word;
                overflow-wrap: break-word;
            }

            /* Specific column widths for mobile */
            table th:nth-child(1),
            table td:nth-child(1) {
                width: 35%;
                white-space: normal;
            }

            table th:nth-child(2),
            table td:nth-child(2) {
                width: 25%;
                white-space: normal;
            }

            table th:nth-child(3),
            table td:nth-child(3) {
                width: 20%;
                white-space: nowrap;
                font-size: 11px;
            }

            table th:nth-child(4),
            table td:nth-child(4) {
                width: 20%;
            }

            .kos-name {
                font-size: 12px;
                line-height: 1.4;
                font-weight: 600;
            }

            .room-type {
                font-size: 11px;
                color: #64748b;
                margin-top: 2px;
            }

            .header-icons {
                gap: 10px;
            }

            .icon-btn {
                width: 36px;
                height: 36px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }

            .btn-verify, .btn-reject {
                width: 100%;
                padding: 8px 6px;
                font-size: 11px;
            }

            .status-badge {
                font-size: 10px;
                padding: 4px 6px;
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

            table {
                font-size: 11px;
            }

            table th,
            table td {
                padding: 8px 4px;
            }

            .btn-verify, .btn-reject {
                font-size: 10px;
                padding: 6px 4px;
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
                <div class="admin-name">Administrator</div>
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
                <a href="/transaksi" class="menu-item active">
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
                    <h1>Transaksi</h1></div>
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

                <!-- Monitoring Pembayaran Tertunda -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title">Monitoring Pembayaran Tertunda</h2>
                            <p class="card-subtitle">({{ $pendingPayments->count() }} Pembayaran menunggu verifikasi)</p>
                        </div>
                        <button class="btn-warning">
                            <i class="fas fa-exclamation-triangle"></i> Perlu Perhatian
                        </button>
                    </div>
                    <div class="card-content">
                        @if($session_success = session('success'))
                        <div style="background-color: #dcfce7; color: #166534; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                            {{ $session_success }}
                        </div>
                        @endif
                        
                        @if($pendingPayments->count() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th>ID PAYMENT</th>
                                    <th>PENYEWA</th>
                                    <th>JUMLAH</th>
                                    <th>TGL. UPLOAD</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingPayments as $payment)
                                <tr>
                                    <td>#{{ $payment->id }}</td>
                                    <td>{{ $payment->booking->penyewa->name ?? 'User Terhapus' }}</td>
                                    <td><span class="price-green">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <form action="/transaksi/verify/{{ $payment->id }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-verify" onclick="return confirm('Verifikasi pembayaran ini?')">Verifikasi</button>
                                            </form>
                                            <form action="/transaksi/reject/{{ $payment->id }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-reject" onclick="return confirm('Tolak pembayaran ini?')">Tolak</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div style="text-align: center; padding: 20px; color: #64748b;">
                            Tidak ada pembayaran yang menunggu verifikasi
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Daftar Booking Aktif & Pending -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-title">Daftar Booking Aktif & Pending</h2>
                            <p class="card-subtitle">({{ $bookings->count() }} Booking)</p>
                        </div>
                        
                    </div>
                    <div class="card-content">
                        @if($bookings->count() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th>KOS & KAMAR</th>
                                    <th>PENYEWA</th>
                                    <th>TGL. BOOKING</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->kamar->kos->nama_kos ?? 'Kos Tidak Ada' }}</strong><br>
                                        <small>{{ $booking->kamar->nomor_kamar ?? '-' }} - {{ $booking->kamar->tipe_kamar ?? '-' }}</small>
                                    </td>
                                    <td>{{ $booking->penyewa->name ?? 'User Terhapus' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</td>
                                    <td>
                                        @if($booking->status == 'aktif')
                                            <span class="status-badge dibayar" style="background-color: #dcfce7; color: #166534;">Aktif/Dibayar</span>
                                        @elseif($booking->status == 'menunggu_pembayaran')
                                            <span class="status-badge" style="background-color: #fef9c3; color: #854d0e;">Menunggu Bayar</span>
                                        @elseif($booking->status == 'menunggu_konfirmasi')
                                            <span class="status-badge" style="background-color: #e0f2fe; color: #0369a1;">Menunggu Konfirmasi</span>
                                        @elseif($booking->status == 'ditolak' || $booking->status == 'dibatalkan')
                                            <span class="status-badge" style="background-color: #fee2e2; color: #991b1b;">{{ ucfirst($booking->status) }}</span>
                                        @else
                                            <span class="status-badge">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div style="text-align: center; padding: 20px; color: #64748b;">
                            Belum ada data booking
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
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
