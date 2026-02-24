<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kamar - KosConnect</title>
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



        /* Dashboard Content */
        .dashboard-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 30px;
            color: #1e293b;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            position: relative;
            overflow: hidden;
        }

        .back-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .back-btn:hover::before {
            left: 100%;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateX(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* Kamar Section */
        .kamar-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .kamar-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .kamar-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            position: relative;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .kamar-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #7c3aed, #3b82f6, #06b6d4);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .kamar-card:hover::before {
            transform: scaleX(1);
        }

        .kamar-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .kamar-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.3s;
        }

        .action-btn.edit {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .action-btn.edit:hover {
            background-color: #bfdbfe;
        }

        .action-btn.delete {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .action-btn.delete:hover {
            background-color: #fecaca;
        }

        .kamar-name {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .kamar-details {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 15px;
        }

        .kamar-detail {
            display: flex;
            align-items: center;
            color: #64748b;
            font-size: 14px;
        }

        .kamar-detail i {
            margin-right: 8px;
            width: 16px;
            color: #3b82f6;
        }

        .kamar-price {
            font-size: 16px;
            font-weight: 600;
            color: #7c3aed;
            margin-bottom: 15px;
        }

        .kamar-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .kamar-status.available {
            background-color: #dcfce7;
            color: #166534;
        }

        .kamar-status.occupied {
            background-color: #fee2e2;
            color: #dc2626;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .close {
            color: #64748b;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close:hover {
            color: #1e293b;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
        }

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background-color: white;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-select:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            display: none;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
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

            .kamar-grid {
                grid-template-columns: 1fr;
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
                <a href="/pemilik/manajemen-kos" class="menu-item active">
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
                    <h1>Manajemen Kamar</h1></div>
                <div class="header-icons">
                    <form method="GET" action="/profil-pemilik" style="display: inline;">
                        @csrf
                        <button type="submit" class="icon-btn">
                            <i class="fas fa-user"></i>
                        </button>
                    </form>
                    <form method="GET" action="#" style="display: inline;">
                        @csrf
                        <button type="button" class="icon-btn notification">
                            <i class="fas fa-bell"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <a href="/pemilik/manajemen-kos" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Manajemen Kos
                </a>



                <!-- Kamar Section -->
                <div class="kamar-section">
                    <div class="section-header">
                        <h2 class="section-title">Daftar Kamar</h2>
                        <button onclick="openModal()" class="btn-primary">
                            <i class="fas fa-plus"></i> Tambah Kamar Baru
                        </button>
                    </div>
                    <div class="kamar-grid">
                        @if($kamar->count() > 0)
                            @foreach($kamar as $item)
                            <div class="kamar-card">
                                <div class="kamar-actions">
                                    <button onclick="openEditModal({{ json_encode($item) }})" class="action-btn edit" title="Edit Kamar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="/pemilik/delete-kamar/{{ $item->id }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Hapus Kamar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="kamar-name">Kamar {{ $item->nomor_kamar }}</div>
                                <div class="kamar-details">
                                    <div class="kamar-detail">
                                        <i class="fas fa-bed"></i>
                                        {{ $item->tipe_kamar }}
                                    </div>
                                    <div class="kamar-detail">
                                        <i class="fas fa-expand"></i>
                                        {{ $item->luas }} m²
                                    </div>
                                    @if($item->fasilitas && is_array($item->fasilitas))
                                    <div class="kamar-detail">
                                        <i class="fas fa-concierge-bell"></i>
                                        {{ implode(', ', $item->fasilitas) }}
                                    </div>
                                    @endif
                                </div>
                                @if($item->gambar_url)
                                <div style="margin-bottom: 15px;">
                                    <img src="{{ $item->gambar_url }}" alt="Gambar Kamar" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;">
                                </div>
                                @endif
                                <div class="kamar-price">Rp {{ number_format($item->harga, 0, ',', '.') }} /bulan</div>
                                <span class="kamar-status {{ $item->status === 'tersedia' ? 'available' : 'occupied' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                            @endforeach
                        @else
                            <div class="empty-state" style="grid-column: 1 / -1;">
                                <i class="fas fa-bed"></i>
                                <h3>Belum Ada Kamar</h3>
                                <p>Belum ada kamar yang terdaftar untuk kos ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Kamar Modal -->
    <div id="addKamarModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Tambah Kamar Baru</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form method="POST" action="/pemilik/tambah-kamar" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="kos_id" value="{{ $kos->id }}">
                <div class="form-group">
                    <label class="form-label" for="nomor_kamar">Nomor Kamar</label>
                    <input type="text" id="nomor_kamar" name="nomor_kamar" class="form-input" placeholder="Contoh: 101" required value="{{ old('nomor_kamar') }}">
                    @error('nomor_kamar') <div class="error-message" style="display:block; color:red; font-size:12px;">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="tipe_kamar">Tipe Kamar</label>
                    <select id="tipe_kamar" name="tipe_kamar" class="form-select" required>
                        <option value="" disabled selected>Pilih tipe kamar</option>
                        <option value="Standard" {{ old('tipe_kamar') == 'Standard' ? 'selected' : '' }}>Standard</option>
                        <option value="Deluxe" {{ old('tipe_kamar') == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                        <option value="Single Room" {{ old('tipe_kamar') == 'Single Room' ? 'selected' : '' }}>Single Room</option>
                    </select>
                    @error('tipe_kamar') <div class="error-message" style="display:block; color:red; font-size:12px;">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="harga">Harga per Bulan (Rp)</label>
                    <input type="number" id="harga" name="harga" class="form-input" placeholder="Contoh: 750000" required min="0" value="{{ old('harga') }}">
                    @error('harga') <div class="error-message" style="display:block; color:red; font-size:12px;">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="luas">Luas (m²)</label>
                    <input type="number" id="luas" name="luas" class="form-input" placeholder="Contoh: 12" required min="0" value="{{ old('luas') }}">
                    @error('luas') <div class="error-message" style="display:block; color:red; font-size:12px;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Fasilitas</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                            <input type="checkbox" name="fasilitas[]" value="AC"> AC
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                            <input type="checkbox" name="fasilitas[]" value="WiFi"> WiFi
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                            <input type="checkbox" name="fasilitas[]" value="Kamar Mandi Dalam"> Kamar Mandi Dalam
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                            <input type="checkbox" name="fasilitas[]" value="Lemari"> Lemari
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="gambar">Foto Kamar (Opsional)</label>
                    <input type="file" id="gambar" name="gambar" class="form-input" accept="image/*">
                    <p style="font-size: 12px; color: #64748b; margin-top: 5px;">Format: JPG, PNG, JPEG. Max: 2MB</p>
                    @error('gambar') <div class="error-message" style="display:block; color:red; font-size:12px;">{{ $message }}</div> @enderror
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Kamar Modal -->
    <div id="editKamarModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Kamar</h2>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <form method="POST" action="/pemilik/update-kamar" enctype="multipart/form-data" id="editKamarForm">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label class="form-label" for="edit_nomor_kamar">Nomor Kamar</label>
                    <input type="text" id="edit_nomor_kamar" name="nomor_kamar" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit_tipe_kamar">Tipe Kamar</label>
                    <select id="edit_tipe_kamar" name="tipe_kamar" class="form-select" required>
                        <option value="Standard">Standard</option>
                        <option value="Deluxe">Deluxe</option>
                        <option value="Single Room">Single Room</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit_harga">Harga per Bulan (Rp)</label>
                    <input type="number" id="edit_harga" name="harga" class="form-input" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label" for="edit_luas">Luas (m²)</label>
                    <input type="number" id="edit_luas" name="luas" class="form-input" required min="0">
                </div>

                <div class="form-group">
                    <label class="form-label">Fasilitas</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                            <input type="checkbox" name="fasilitas[]" value="AC" id="edit_fasilitas_AC"> AC
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                            <input type="checkbox" name="fasilitas[]" value="WiFi" id="edit_fasilitas_WiFi"> WiFi
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                            <input type="checkbox" name="fasilitas[]" value="Kamar Mandi Dalam" id="edit_fasilitas_KamarMandiDalam"> Kamar Mandi Dalam
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                            <input type="checkbox" name="fasilitas[]" value="Lemari" id="edit_fasilitas_Lemari"> Lemari
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="edit_gambar">Foto Kamar (Opsional)</label>
                    <input type="file" id="edit_gambar" name="gambar" class="form-input" accept="image/*">
                    <p style="font-size: 12px; color: #64748b; margin-top: 5px;">Biarkan kosong jika tidak ingin mengubah foto</p>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeEditModal()">Batal</button>
                    <button type="submit" class="btn-primary">Update Kamar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('addKamarModal');
        const editModal = document.getElementById('editKamarModal');

        function openModal() {
            modal.style.display = 'block';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        function openEditModal(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_nomor_kamar').value = data.nomor_kamar;
            document.getElementById('edit_tipe_kamar').value = data.tipe_kamar;
            // Ensure harga is parsed as an integer to remove decimals if any
            document.getElementById('edit_harga').value = Math.floor(data.harga); 
            document.getElementById('edit_luas').value = data.luas;

            // Reset checkboxes
            document.getElementById('edit_fasilitas_AC').checked = false;
            document.getElementById('edit_fasilitas_WiFi').checked = false;
            document.getElementById('edit_fasilitas_KamarMandiDalam').checked = false;
            document.getElementById('edit_fasilitas_Lemari').checked = false;

            // Check fasilitas if they exist
            if (data.fasilitas && Array.isArray(data.fasilitas)) {
                data.fasilitas.forEach(fas => {
                    if (fas === 'AC') document.getElementById('edit_fasilitas_AC').checked = true;
                    if (fas === 'WiFi') document.getElementById('edit_fasilitas_WiFi').checked = true;
                    if (fas === 'Kamar Mandi Dalam') document.getElementById('edit_fasilitas_KamarMandiDalam').checked = true;
                    if (fas === 'Lemari') document.getElementById('edit_fasilitas_Lemari').checked = true;
                });
            }

            editModal.style.display = 'block';
        }

        function closeEditModal() {
            editModal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
            if (event.target == editModal) {
                closeEditModal();
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
