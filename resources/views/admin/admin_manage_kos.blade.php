<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="{{ asset('images/logo-kosconnect.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Kos - KosConnect</title>
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
            transition: all 0.3s ease;
            animation: avatarFadeIn 0.6s ease-out;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        @keyframes avatarFadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .admin-avatar:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
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
            position: relative;
            overflow: hidden;
            opacity: 1;
        }

        .menu-item:hover::before {
            left: 100%;
        }

        .menu-item:hover {
            background-color: #334155;
            color: white;
        }

        .menu-item.active {
            background-color: #334155;
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

        /* Header */
        .header {
            background-color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-title h1 {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
        }

        .header-icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #3b82f6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
            position: relative;
        }

        .icon-btn:hover {
            background-color: #2563eb;
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

        /* Table Section */
        .table-section {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .table-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
        }
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }

        .btn-primary i {
            margin-right: 8px;
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

        tbody tr {
            opacity: 1;
        }

        tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }

        .price-green {
            color: #166534;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-edit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-edit:hover::before {
            left: 100%;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-delete::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-delete:hover::before {
            left: 100%;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
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
            max-width: 500px;
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

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #3b82f6;
        }

        .modal-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        /* Footer */
        .footer {
            background-color: white;
            padding: 20px 30px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
            border-top: 1px solid #e2e8f0;
        }

        a.btn {
            text-decoration: none;
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

            .table-section {
                overflow-x: auto;
            }

            table {
                min-width: 700px;
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
                <a href="/data-kos" class="menu-item active">
                    <i class="fas fa-building"></i>
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
            <!-- Header -->
            <div class="header">
                <div class="header-title">
                    <h1>Data Kos</h1></div>
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

                <!-- Table Section -->
                <div class="table-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h2 class="table-title">Manajemen Semua Data Kos</h2>
                        <button onclick="openAddKosModal()" class="btn-primary"><i class="fas fa-plus"></i> Tambah Kos Baru</button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>NAMA KOS</th>
                                <th>PEMILIK</th>
                                <th>HARGA DASAR</th>
                                <th>ALAMAT</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kos ?? [] as $kosItem)
                            <tr data-kos-id="{{ $kosItem->id }}">
                                <td>{{ $kosItem->nama_kos }}</td>
                                <td>{{ $kosItem->pemilik->nama_user ?? 'N/A' }}</td>
                                <td><span class="price-green">Rp {{ number_format($kosItem->harga_dasar, 0, ',', '.') }}</span></td>
                                <td>{{ $kosItem->alamat }}, {{ $kosItem->kota }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn-edit" 
                                            onclick="openEditKosModal('{{$kosItem->id}}', '{{addslashes($kosItem->nama_kos)}}', '{{$kosItem->pemilik_id}}', '{{$kosItem->harga_dasar}}', '{{addslashes($kosItem->alamat)}}', '{{addslashes($kosItem->kota)}}', '{{addslashes($kosItem->provinsi)}}', '{{addslashes($kosItem->deskripsi ?? '')}}')">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form id="delete-kos-form-{{$kosItem->id}}" action="/delete-kos/{{$kosItem->id}}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-delete" onclick="confirmDeleteKos('{{$kosItem->id}}', '{{addslashes($kosItem->nama_kos)}}')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #64748b; padding: 30px;">Tidak ada data kos</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                © 2025 KosConnect. All rights reserved.
            </div>
        </div>
    </div>
    <!-- Add Kos Modal -->
    <div id="addKosModal" class="modal-overlay" style="display: none;">
        <div class="modal">
            <div class="modal-header">
                <h2>Tambah Kos Baru</h2>
                <button class="close-btn" onclick="closeAddKosModal()">&times;</button>
            </div>
            <form action="/store-kos-admin" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_nama_kos">Nama Kos</label>
                        <input type="text" id="add_nama_kos" name="nama_kos" required>
                    </div>

                    <div class="form-group">
                        <label for="add_pemilik_id">Pemilik Kos</label>
                        <select id="add_pemilik_id" name="pemilik_id" required>
                            <option value="">Pilih Pemilik</option>
                            @foreach($owners ?? [] as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->nama_user }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="add_harga_dasar">Harga Dasar</label>
                        <input type="number" id="add_harga_dasar" name="harga_dasar" required min="0">
                    </div>

                    <div class="form-group">
                        <label for="add_alamat">Alamat Lengkap</label>
                        <input type="text" id="add_alamat" name="alamat" required>
                    </div>

                    <div class="form-group" style="display: flex; gap: 10px;">
                        <div style="flex: 1;">
                            <label for="add_kota">Kota</label>
                            <input type="text" id="add_kota" name="kota" required>
                        </div>
                        <div style="flex: 1;">
                            <label for="add_provinsi">Provinsi</label>
                            <input type="text" id="add_provinsi" name="provinsi" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="add_deskripsi">Deskripsi</label>
                        <textarea id="add_deskripsi" name="deskripsi" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;" rows="3"></textarea>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn-secondary" onclick="closeAddKosModal()">Batal</button>
                        <button type="submit" class="btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Kos Modal -->
    <div id="editKosModal" class="modal-overlay" style="display: none;">
        <div class="modal">
            <div class="modal-header">
                <h2>Edit Data Kos</h2>
                <button class="close-btn" onclick="closeEditKosModal()">&times;</button>
            </div>
            <form id="editKosForm" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama_kos">Nama Kos</label>
                        <input type="text" id="edit_nama_kos" name="nama_kos" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_pemilik_id">Pemilik Kos</label>
                        <select id="edit_pemilik_id" name="pemilik_id" required>
                            <option value="">Pilih Pemilik</option>
                            @foreach($owners ?? [] as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->nama_user }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_harga_dasar">Harga Dasar</label>
                        <input type="number" id="edit_harga_dasar" name="harga_dasar" required min="0">
                    </div>

                    <div class="form-group">
                        <label for="edit_alamat">Alamat Lengkap</label>
                        <input type="text" id="edit_alamat" name="alamat" required>
                    </div>

                    <div class="form-group" style="display: flex; gap: 10px;">
                        <div style="flex: 1;">
                            <label for="edit_kota">Kota</label>
                            <input type="text" id="edit_kota" name="kota" required>
                        </div>
                        <div style="flex: 1;">
                            <label for="edit_provinsi">Provinsi</label>
                            <input type="text" id="edit_provinsi" name="provinsi" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_deskripsi">Deskripsi</label>
                        <textarea id="edit_deskripsi" name="deskripsi" style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px;" rows="3"></textarea>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn-secondary" onclick="closeEditKosModal()">Batal</button>
                        <button type="submit" class="btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddKosModal() {
            document.getElementById('addKosModal').style.display = 'flex';
        }

        function closeAddKosModal() {
            document.getElementById('addKosModal').style.display = 'none';
        }

        function openEditKosModal(id, nama, pemilik_id, harga, alamat, kota, provinsi, deskripsi) {
            document.getElementById('editKosForm').action = '/update-kos-admin/' + id;
            document.getElementById('edit_nama_kos').value = nama;
            document.getElementById('edit_pemilik_id').value = pemilik_id;
            document.getElementById('edit_harga_dasar').value = harga;
            document.getElementById('edit_alamat').value = alamat;
            document.getElementById('edit_kota').value = kota;
            document.getElementById('edit_provinsi').value = provinsi;
            document.getElementById('edit_deskripsi').value = deskripsi;

            document.getElementById('editKosModal').style.display = 'flex';
        }

        function closeEditKosModal() {
            document.getElementById('editKosModal').style.display = 'none';
        }

        function confirmDeleteKos(id, name) {
            Swal.fire({
                title: 'Hapus Kos?',
                text: "Anda yakin ingin menghapus data kos " + name + "? Data kamar dan booking terkait juga mungkin akan terhapus/gagal.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-kos-form-' + id).submit();
                }
            })
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modalAdd = document.getElementById('addKosModal');
            var modalEdit = document.getElementById('editKosModal');
            var dropdown = document.getElementById('notificationDropdown');
            var notificationBtn = document.getElementById('notificationBtn');

            if (event.target == modalAdd) {
                modalAdd.style.display = 'none';
            }
            if (event.target == modalEdit) {
                modalEdit.style.display = 'none';
            }
            
            // Close notification dropdown when clicking outside
            if (dropdown && dropdown.classList.contains('active') && !dropdown.contains(event.target) && event.target !== notificationBtn && !notificationBtn.contains(event.target)) {
                dropdown.classList.remove('active');
            }
            
            // Close mobile menu when clicking outside overlay
             const overlay = document.querySelector('.mobile-overlay');
             if(event.target == overlay) {
                toggleMobileMenu();
             }
        }

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
    @include('components.sweetalert')
</body>
</html>
