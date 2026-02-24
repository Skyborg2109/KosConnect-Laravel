

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keluhan Kos - KosConnect</title>
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

        @keyframes activePulse {
            0%, 100% { box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
            50% { box-shadow: 0 4px 20px rgba(59, 130, 246, 0.5); }
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

        /* Header Icons - Restored & Synced */
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
            border: none;
            padding: 0;
        }

        .icon-btn:hover {
            background-color: #2563eb;
        }

        .icon-btn.notification {
            position: relative;
        }
        




        /* == MAIN LAYOUT & COMPONENTS (Restored) == */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

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

        .dashboard-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            animation: contentFadeIn 0.8s ease-out;
        }

        @keyframes contentFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #1e293b;
            animation: titleSlideIn 0.6s ease-out;
        }

        @keyframes titleSlideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Summary Card */
        .summary-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
            position: relative;
            animation: summaryCardFadeIn 0.8s ease-out;
            overflow: hidden;
        }

        @keyframes summaryCardFadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f59e0b, #ef4444, #8b5cf6);
            transform: scaleX(0);
            transform-origin: left;
            animation: summaryHeaderSlide 1s ease-out 0.5s both;
        }

        @keyframes summaryHeaderSlide {
            to { transform: scaleX(1); }
        }

        .summary-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .summary-subtitle {
            font-size: 14px;
            color: #64748b;
        }

        .attention-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #f59e0b;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Complaints List */
        .complaints-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            animation: complaintsSectionFadeIn 0.8s ease-out;
        }

        @keyframes complaintsSectionFadeIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .complaints-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .complaint-card {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 2px solid #ef4444;
            border-radius: 12px;
            padding: 20px;
            position: relative;
            animation: complaintCardSlideIn 0.6s ease-out both;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .complaint-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.2);
            border-color: #dc2626;
        }

        .complaint-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .complaint-card:hover::before {
            left: 100%;
        }

        @keyframes complaintCardSlideIn {
            from { opacity: 0; transform: translateX(-40px) scale(0.9); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #f472b6;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .complaint-header {
            margin-bottom: 15px;
        }

        .complaint-from {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .complaint-details {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 5px;
        }

        .complaint-message {
            font-size: 16px;
            color: #1e293b;
            margin-bottom: 20px;
            font-style: italic;
        }

        .complaint-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-selesai {
            padding: 10px 20px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: buttonBounceIn 0.5s ease-out both;
        }
        
        .btn-selesai:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-diproses {
            padding: 10px 20px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: buttonBounceIn 0.5s ease-out both;
        }
        
        .btn-diproses:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }
        /* Sidebar override removed */

        .btn, .btn-diproses {
            position: relative;
            overflow: hidden;
        }

        .btn::before, .btn-diproses::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before, .btn-diproses:hover::before {
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

            .dashboard-content {
                padding: 20px 15px;
            }

            .complaint-card {
                padding: 15px;
            }

            .complaint-actions {
                flex-direction: column;
                gap: 8px;
            }

            .btn-selesai, .btn-diproses {
                width: 100%;
                justify-content: center;
            }

            .status-badge {
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
                <a href="/pemilik/kelola-pesanan" class="menu-item">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Kelola Pesanan</span>
                </a>
                <a href="/pemilik/keluhan-kos" class="menu-item active">
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
                    <h1>Keluhan Kos</h1></div>
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


                <!-- Summary Card -->
                <div class="summary-card">
                    <div class="attention-badge">
                        <i class="fas fa-exclamation-triangle"></i> Perlu Perhatian
                    </div>
                    <div class="summary-title">Keluhan Kos Milik Anda</div>
                    <div class="summary-subtitle">({{ $keluhans->where('status', '!=', 'selesai')->count() }} keluhan aktif)</div>
                </div>

                <!-- Complaints Section -->
                <div class="complaints-section">
                    <div class="complaints-list">
                        @forelse($keluhans as $keluhan)
                            <div class="complaint-card">
                                @php
                                    $statusClass = '';
                                    $statusLabel = ucfirst($keluhan->status);
                                    if($keluhan->status == 'pending') $statusClass = 'bg-danger'; 
                                    elseif($keluhan->status == 'diproses') $statusClass = 'bg-primary';
                                    elseif($keluhan->status == 'selesai') $statusClass = 'bg-success';
                                    
                                    $priorityClass = '';
                                    if($keluhan->prioritas == 'tinggi') $priorityClass = '#dc3545'; // Red
                                    elseif($keluhan->prioritas == 'sedang') $priorityClass = '#ffc107'; // Yellow
                                    else $priorityClass = '#198754'; // Green
                                @endphp
                                
                                <span class="status-badge" style="background-color: {{ $priorityClass }}; right: 90px;">
                                    {{ ucfirst($keluhan->prioritas) }}
                                </span>
                                
                                <span class="status-badge" style="background-color: {{ $keluhan->status == 'selesai' ? '#10b981' : ($keluhan->status == 'diproses' ? '#3b82f6' : '#f472b6') }}">
                                    {{ $statusLabel }}
                                </span>

                                <div class="complaint-header">
                                    <div class="complaint-from">Keluhan dari {{ $keluhan->penyewa->nama_user }}</div>
                                    <div class="complaint-details">Kos: {{ $keluhan->kos->nama_kos }}</div>
                                    <div class="complaint-details">Kategori: {{ ucfirst($keluhan->kategori ?? '-') }}</div>
                                    <div class="complaint-details">Tgl. {{ $keluhan->created_at->format('d M Y') }}</div>
                                </div>
                                <div class="complaint-message">"{{ $keluhan->deskripsi }}"</div>
                                
                                @if($keluhan->bukti)
                                    <div style="margin-bottom: 15px;">
                                        <a href="{{ $keluhan->bukti }}" target="_blank" style="text-decoration: none; color: #3b82f6; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                                            <i class="fas fa-paperclip"></i> Lihat Bukti Foto/Video
                                        </a>
                                    </div>
                                @endif

                                <div class="complaint-actions">
                                    @if($keluhan->status == 'pending')
                                        <form id="form-proses-{{ $keluhan->id }}" method="POST" action="/pemilik/keluhan/{{ $keluhan->id }}/diproses" style="display: inline;">
                                            @csrf
                                            <button type="button" class="btn-diproses" onclick="confirmProses('{{ $keluhan->id }}')">
                                                <i class="fas fa-clock"></i> Set Diproses
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($keluhan->status != 'selesai')
                                        <form id="form-selesai-{{ $keluhan->id }}" method="POST" action="/pemilik/keluhan/{{ $keluhan->id }}/selesai" style="display: inline;">
                                            @csrf
                                            <button type="button" class="btn-selesai" onclick="confirmSelesai('{{ $keluhan->id }}')">
                                                <i class="fas fa-check"></i> Tanda Selesai
                                            </button>
                                        </form>
                                    @else
                                        <div style="color: #10b981; font-weight: 600; font-size: 14px;">
                                            <i class="fas fa-check-circle"></i> Selesai pada {{ $keluhan->tanggal_selesai ? \Carbon\Carbon::parse($keluhan->tanggal_selesai)->format('d M Y') : '-' }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 40px; color: #64748b;">
                                <i class="fas fa-check-circle" style="font-size: 48px; margin-bottom: 15px; color: #cbd5e1;"></i>
                                <p>Tidak ada keluhan saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @include('components.sweetalert')
    <script>
        function confirmProses(id) {
            Swal.fire({
                title: 'Proses Keluhan?',
                text: "Status keluhan akan diubah menjadi 'Diproses'.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-proses-' + id).submit();
                }
            })
        }

        function confirmSelesai(id) {
            Swal.fire({
                title: 'Tandai Selesai?',
                text: "Pastikan keluhan benar-benar telah diselesaikan.",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Selesai!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-selesai-' + id).submit();
                }
            })
        }

        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            const badge = document.querySelector('.notification-badge');
            
            if (!dropdown.classList.contains('active')) {
                fetch('/pemilik/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok && badge) badge.style.display = 'none';
                });
            }
            dropdown.classList.toggle('active');
        }

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
