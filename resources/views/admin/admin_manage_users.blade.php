<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="{{ asset('images/logo-kosconnect.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna - KosConnect</title>
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

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-edit {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
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
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
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

        .btn-block {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
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

        .btn-block::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-block:hover::before {
            left: 100%;
        }

        .btn-block:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
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
                min-width: 800px;
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
                <a href="/data-pengguna" class="menu-item active">
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
                    <h1>Data Pengguna</h1></div>
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

                @if(session('success'))
                <div style="background-color: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
                @endif


                <!-- Table Section -->
                <div class="table-section">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h2 class="table-title">Manajemen Data Pengguna</h2>
                        <button onclick="openAddUserModal()" class="btn-primary"><i class="fas fa-plus"></i> Tambah Pengguna</button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NAMA LENGKAP</th>
                                <th>EMAIL</th>
                                <th>NOMOR TELEPON</th>
                                <th>ROLE</th>
                                <th>STATUS AKTIVASI</th>
                                <th>STATUS AKUN</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>{{$user->nama_user}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->nomor_telepon ?? '-'}}</td>
                                <td>{{$user->role}}</td>
                                <td>
                                    @if($user->status == 'blokir')
                                        <span class="status-badge" style="background-color: #fee2e2; color: #991b1b;">Diblokir</span>
                                    @else
                                        <span class="status-badge selesai">Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge selesai">Aktif</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn-edit" 
                                            onclick="openEditUserModal('{{ $user->id }}', '{{ addslashes($user->nama_user) }}', '{{ addslashes($user->email) }}', '{{ $user->nomor_telepon ?? '' }}', '{{ $user->role }}')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form id="block-form-{{$user->id}}" action="/toggle-status-user/{{$user->id}}" method="POST" style="display:none;">
                                            @csrf
                                        </form>
                                        <button type="button" class="btn-block" 
                                            onclick="confirmBlock('{{$user->id}}', '{{$user->status}}')"
                                            style="{{ $user->status == 'blokir' ? 'background: linear-gradient(135deg, #10b981 0%, #059669 100%);' : '' }}">
                                            {{ $user->status == 'blokir' ? 'Aktifkan' : 'Blokir' }}
                                        </button>

                                        <form id="delete-form-{{$user->id}}" action="/delete-user/{{$user->id}}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="button" class="btn-delete" onclick="confirmDelete('{{$user->id}}', '{{ addslashes($user->nama_user) }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal-overlay" style="display: none;">
        <div class="modal">
            <div class="modal-header">
                <h2>Edit Pengguna</h2>
                <button class="close-btn" onclick="closeEditUserModal()">&times;</button>
            </div>
            <form id="editUserForm" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nama_user">Nama Lengkap</label>
                        <input type="text" id="edit_nama_user" name="nama_user" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" id="edit_email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_nomor_telepon">Nomor Telepon</label>
                        <input type="text" id="edit_nomor_telepon" name="nomor_telepon">
                    </div>

                    <div class="form-group">
                        <label for="edit_role">Role</label>
                        <select id="edit_role" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="pemilik">Pemilik</option>
                            <option value="penyewa">Penyewa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_password">Password Baru</label>
                        <input type="password" id="edit_password" name="password" placeholder="........">
                        <small style="color: #64748b; font-size: 12px; font-style: italic; margin-top: 5px; display: block;">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn-secondary" onclick="closeEditUserModal()">Batal</button>
                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal-overlay" style="display: none;">
        <div class="modal">
            <div class="modal-header">
                <h2>Tambah Pengguna Baru</h2>
                <button class="close-btn" onclick="closeAddUserModal()">&times;</button>
            </div>
            <form action="/store-user" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_nama_user">Nama Lengkap</label>
                        <input type="text" id="add_nama_user" name="nama_user" required placeholder="Nama Lengkap">
                    </div>

                    <div class="form-group">
                        <label for="add_email">Email</label>
                        <input type="email" id="add_email" name="email" required placeholder="email@example.com">
                    </div>

                    <div class="form-group">
                        <label for="add_nomor_telepon">Nomor Telepon</label>
                        <input type="text" id="add_nomor_telepon" name="nomor_telepon" placeholder="08xxxxxxxxxx">
                    </div>

                    <div class="form-group">
                        <label for="add_role">Role</label>
                        <select id="add_role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="pemilik">Pemilik</option>
                            <option value="penyewa">Penyewa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="add_password">Password</label>
                        <input type="password" id="add_password" name="password" required placeholder="Minimal 6 karakter">
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn-secondary" onclick="closeAddUserModal()">Batal</button>
                        <button type="submit" class="btn-primary">Tambah User</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddUserModal() {
            document.getElementById('addUserModal').style.display = 'flex';
        }

        function closeAddUserModal() {
            document.getElementById('addUserModal').style.display = 'none';
        }

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus User?',
                text: "Anda yakin ingin menghapus user " + name + "? Data tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }

        function confirmBlock(id, status) {
            let isBlocked = status == 'blokir';
            let action = isBlocked ? 'Aktifkan' : 'Blokir';
            let confirmColor = isBlocked ? '#10b981' : '#d33';
            let titleText = isBlocked ? 'Aktifkan User?' : 'Blokir User?';
            let msgText = isBlocked ? "User akan dapat mengakses kembali akunnya." : "User tidak akan bisa login ke aplikasi.";

            Swal.fire({
                title: titleText,
                text: msgText,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, ' + action + '!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('block-form-' + id).submit();
                }
            })
        }

        function openEditUserModal(id, nama, email, telepon, role) {
            document.getElementById('editUserForm').action = '/update-user/' + id;
            document.getElementById('edit_nama_user').value = nama;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_nomor_telepon').value = telepon;
            document.getElementById('edit_role').value = role;
            
            // Reset password field
            document.getElementById('edit_password').value = '';

            document.getElementById('editUserModal').style.display = 'flex';
        }

        function closeEditUserModal() {
            document.getElementById('editUserModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var modal = document.getElementById('editUserModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
    @include('components.sweetalert')
    <script>
        function toggleMobileMenu() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('active');
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
