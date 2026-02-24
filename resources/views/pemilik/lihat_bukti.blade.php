<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lihat Bukti Pembayaran - KosConnect</title>
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

        /* Back Button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
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
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        /* Payment Proof Section */
        .proof-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .proof-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #06b6d4, #3b82f6);
            transform: scaleX(1);
            transform-origin: left;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #1e293b;
        }

        .payment-info {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 4px solid #3b82f6;
            margin-bottom: 25px;
            border-left: 4px solid #3b82f6;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
        }

        .info-value {
            color: #6b7280;
        }

        .proof-image-container {
            text-align: center;
            margin-top: 30px;
            text-align: center;
            margin-top: 30px;
        }


        .proof-image {
            max-width: 100%;
            max-height: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            margin-bottom: 20px;
            transition: all 0.3s ease;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .proof-image:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .no-proof {
            padding: 40px;
            text-align: center;
            color: #6b7280;
            font-size: 16px;
        }

        .no-proof i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #d1d5db;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn-verify {
            padding: 12px 25px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-verify:hover::before {
            left: 100%;
        }

        .btn-verify:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-reject {
            padding: 12px 25px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-reject::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-reject:hover::before {
            left: 100%;
        }

        .btn-reject:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
    </style>
</head>
<body>
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
                <a href="/pemilik/verifikasi-pembayaran" class="menu-item active">
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
                    <h1>Lihat Bukti Pembayaran</h1></div>
                <div class="header-icons">
                    <form method="GET" action="/profil-pemilik" style="display: inline;">
                        @csrf
                        <button type="submit" class="icon-btn">
                            <i class="fas fa-user"></i>
                        </button>
                    </form>
                    <form method="GET" action="#" style="display: inline;">
                        @csrf
                        <button type="submit" class="icon-btn notification">
                            <i class="fas fa-bell"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">


                <a href="/pemilik/verifikasi-pembayaran" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Verifikasi Pembayaran
                </a>

                <!-- Payment Proof Section -->
                <div class="proof-section">
                    <h2 class="section-title">Detail Pembayaran #{{ $id }}</h2>

                    <div class="payment-info">
                        @if($id == 1)
                            <div class="info-row">
                                <span class="info-label">Nama Penyewa:</span>
                                <span class="info-value">James</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Kos:</span>
                                <span class="info-value">Capital Kost - Kamar Regular</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tanggal Bayar:</span>
                                <span class="info-value">04 Nov 2025 16:14</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Jumlah:</span>
                                <span class="info-value">Rp 750.000</span>
                            </div>
                        @elseif($id == 2)
                            <div class="info-row">
                                <span class="info-label">Nama Penyewa:</span>
                                <span class="info-value">Thobroni</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Kos:</span>
                                <span class="info-value">Royal Kost - Kamar Premium</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tanggal Bayar:</span>
                                <span class="info-value">04 Nov 2025 14:30</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Jumlah:</span>
                                <span class="info-value">Rp 650.000</span>
                            </div>
                        @endif
                    </div>

                    <div class="proof-image-container">
                        @if($id == 1 || $id == 2)
                            <!-- Placeholder for payment proof image -->
                            <img src="https://via.placeholder.com/600x400/3b82f6/ffffff?text=Bukti+Pembayaran" alt="Bukti Pembayaran" class="proof-image">
                            <p style="color: #6b7280; font-size: 14px; margin-top: 10px;">
                                <i class="fas fa-info-circle"></i>
                                Bukti pembayaran telah diterima dan dapat diverifikasi
                            </p>
                        @else
                            <div class="no-proof">
                                <i class="fas fa-image"></i>
                                <p>Bukti pembayaran tidak tersedia</p>
                            </div>
                        @endif
                    </div>

                    @if($id == 1 || $id == 2)
                    <div class="action-buttons">
                        <form method="POST" action="/pemilik/verifikasi-pembayaran/{{ $id }}" style="display: inline;" class="form-confirm-action" data-title="Verifikasi Pembayaran?" data-text="Pastikan dana sudah masuk ke rekening Anda." data-confirm-text="Ya, Verifikasi" data-confirm-color="#10b981">
                            @csrf
                            <button type="submit" class="btn-verify">
                                <i class="fas fa-check"></i>
                                Verifikasi Pembayaran
                            </button>
                        </form>
                        <form method="POST" action="/pemilik/tolak-pembayaran/{{ $id }}" style="display: inline;" class="form-confirm-action" data-title="Tolak Pembayaran?" data-text="Apakah Anda yakin ingin menolak pembayaran ini? Penyewa harus mengupload ulang bukti pembayaran." data-confirm-text="Ya, Tolak" data-confirm-color="#ef4444">
                            @csrf
                            <button type="submit" class="btn-reject">
                                <i class="fas fa-times"></i>
                                Tolak Pembayaran
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('components.sweetalert')
</body>
</html>