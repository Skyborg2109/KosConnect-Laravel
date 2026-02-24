<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="{{ asset('images/logo-kosconnect.png?v=3') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - KosConnect</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* == CSS RESET & DASAR == */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        a.btn {
            text-decoration: none;
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            color: #333;
            line-height: 1.6;
            padding-top: 70px;
        }

        body.menu-open {
            overflow: hidden !important;
        }

        .container {
            max-width: 1300px;
            margin: 20px auto;
            padding: 0 20px;
        }



        a {
            text-decoration: none;
            color: inherit;
        }

        /* == 1. HEADER & NAVIGASI ATAS == */
        .main-header {
            background-color: #ffffff;
            padding: 0 2rem;
            height: 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1000;
        }

        /* Helper class for desktop-only elements */
        @media (max-width: 768px) {
            .desktop-only {
                display: none !important;
            }
        }

        .mobile-overlay {
            display: none;
        }


        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }
        
        .logo-container a {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: inherit;
            font-size: 1.25rem;
            font-weight: bold;
            color: #2563eb;
            white-space: nowrap;
        }
        
        .logo-container .fa-home {
            font-size: 1.25rem;
            color: #2563eb;
        }

        .main-nav {
            margin-left: auto;
            margin-right: 1rem;
            display: flex;
            align-items: center;
        }

        .main-nav ul {
            list-style: none;
            display: flex;
            flex-direction: row;
            gap: 1.5rem;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .main-nav ul li {
            display: inline-block;
        }

        .main-nav ul li a {
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
            transition: color 0.2s ease;
            white-space: nowrap;
            display: inline-block;
        }

        .main-nav ul li a:hover {
            color: #2563eb;
        }

        /* Hide icons in desktop nav and logo links globally */
        @media (min-width: 769px) {
            .main-nav a i, .logo-container a i, .sidebar-links a i {
                display: none !important;
            }
        }

        /* Notification Styles */
        .notification-wrapper {
            position: relative;
            margin-right: 15px;
        }

        .notification-btn {
            background: none;
            border: none;
            cursor: pointer;
            position: relative;
            color: #64748b;
            font-size: 1.2rem;
        }
        
        .notification-badge {
            position: absolute;
            top: 0;
            right: 0;
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

        /* Profile Avatar Styles */
        .profile-avatar-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            border: 2px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .profile-avatar-wrapper:hover {
            border-color: #2563eb;
            transform: scale(1.05);
        }

        .profile-avatar-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-avatar-placeholder {
            width: 100%;
            height: 100%;
            background-color: #f1f5f9;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
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

        @media (max-width: 768px) {
            .notification-dropdown {
                position: fixed;
                top: 70px;
                left: 10px;
                right: 10px;
                width: auto;
                max-width: none;
            }
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

        .notification-item-container {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .notif-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 14px;
        }

        .notif-icon.booking { background: #dcfce7; color: #166534; }
        .notif-icon.payment { background: #fef9c3; color: #854d0e; }
        .notif-icon.rental { background: #fee2e2; color: #991b1b; }
        .notif-icon.info { background: #e0f2fe; color: #0369a1; }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .notification-message {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .notification-time {
            font-size: 10px;
            color: #94a3b8;
        }
        
        .empty-notification {
            padding: 30px;
            text-align: center;
            color: #94a3b8;
        }

        @media (min-width: 769px) {
            .main-nav ul li a.active {
                color: #2563eb;
                font-weight: 600;
            }
    
            .main-nav ul li a.active::before {
                width: 100%;
                left: 50%;
                transform: translateX(-50%);
                animation: borderSlideIn 0.3s ease-out;
            }
    
            .main-nav ul li a.active::after {
                content: '';
                position: absolute;
                top: -5px;
                left: -5px;
                right: -5px;
                bottom: -5px;
                background: linear-gradient(45deg, rgba(13, 110, 253, 0.1), rgba(13, 110, 253, 0.05));
                border-radius: 4px;
                z-index: -1;
                animation: activeGlow 0.6s ease-out;
            }
        }

        @keyframes activeGlow {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            100% {
                opacity: 0.5;
                transform: scale(1);
            }
        }

        @keyframes borderSlideIn {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        /* Animasi perpindahan menu dengan ripple effect */
        .main-nav ul li a::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background-color: rgba(13, 110, 253, 0.1);
            transform: translate(-50%, -50%);
            transition: all 0.4s ease;
            pointer-events: none;
            z-index: -1;
        }

        .main-nav ul li a:active::after {
            width: 40px;
            height: 40px;
            animation: rippleExpand 0.4s ease-out;
        }

        @keyframes rippleExpand {
            0% {
                width: 0;
                height: 0;
                opacity: 1;
            }
            100% {
                width: 40px;
                height: 40px;
                opacity: 0;
            }
        }

        /* Animasi smooth untuk seluruh navbar */
        .main-nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
        }

        .main-nav ul li:nth-child(1) { }
        .main-nav ul li:nth-child(2) { }
        .main-nav ul li:nth-child(3) { }
        .main-nav ul li:nth-child(4) { }
        .main-nav ul li:nth-child(5) { }
        .main-nav ul li:nth-child(6) { }
        .main-nav ul li:nth-child(7) { }
        .main-nav ul li:nth-child(8) { }
        .main-nav ul li:nth-child(9) { }
        .main-nav ul li:nth-child(10) { }

        .btn-logout {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #ffffff;
            padding: 0.5rem 1.5rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(220, 38, 38, 0.2);
        }
        
        .btn-logout:hover {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(220, 38, 38, 0.3);
        }

        /* == HERO SECTION == */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 60px 40px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 60px;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .hero-content {
            flex: 1;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .hero-title i {
            color: #ffd700;
            font-size: 48px;
        }

        .hero-subtitle {
            font-size: 18px;
            margin-bottom: 32px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-bottom: 40px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 32px;
            font-weight: 700;
            color: #ffd700;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.8;
        }

        .hero-actions {
            display: flex;
            gap: 20px;
        }

        .btn-primary-large,
        .btn-secondary-large {
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn-primary-large {
            background: linear-gradient(45deg, #ffd700, #ffb347);
            color: #333;
        }

        .btn-primary-large:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
        }

        .btn-secondary-large {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary-large:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
        }

        .hero-image {
            flex: 1;
            max-width: 400px;
        }

        .hero-image-placeholder {
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-image-placeholder i {
            font-size: 80px;
            margin-bottom: 16px;
        }

        .hero-image-placeholder span {
            font-size: 18px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .hero-section {
                flex-direction: column;
                text-align: center;
                padding: 40px 20px;
                gap: 40px;
            }

            .hero-title {
                font-size: 32px;
            }

            .hero-stats {
                justify-content: center;
                gap: 20px;
            }

            .hero-actions {
                flex-direction: column;
                align-items: center;
            }

            .btn-primary-large,
            .btn-secondary-large {
                width: 100%;
                justify-content: center;
            }
        }
        
        /* == CSS MODAL OVERLAY == */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 10000;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            backdrop-filter: blur(4px);
        }
        
        .modal-overlay.show {
            display: flex;
            opacity: 1;
            visibility: visible;
        }

        /* FIX: SweetAlert Z-Index Issue - Must be higher than modal-overlay (10000) */
        .swal2-container {
            z-index: 20000 !important;
        }

        .modal-content-wrapper {
            width: 100%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-overlay.show .modal-content-wrapper {
            transform: translateY(0);
        }
        /* == MEDIA QUERIES FOR MOBILE == */
        .mobile-logout-item {
            display: none !important;
        }

        @media (max-width: 768px) {
            .mobile-logout-item {
                display: block !important;
                width: 100%;
                border-top: 2px solid rgba(255, 255, 255, 0.15);
                margin-top: auto;
            }

            .mobile-logout-item button {
                color: #fca5a5 !important;
                font-size: 16px !important;
                font-weight: 700 !important;
                letter-spacing: 0.5px;
            }

            .mobile-logout-item button:hover {
                background-color: rgba(239, 68, 68, 0.1) !important;
                color: #fee2e2 !important;
            }
            .desktop-only {
                display: none !important;
            }

            .main-header {
                padding: 0 1rem;
            }

            .main-nav {
                position: fixed;
                top: 0;
                right: -280px;
                width: 280px;
                height: 100vh;
                margin-right: 0; /* Clear desktop margin */
                background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
                box-shadow: -4px 0 20px rgba(0,0,0,0.3);
                transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1001;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                padding-top: 70px;
                overflow-y: auto;
                overflow-x: hidden;
                visibility: hidden; /* Prevent horizontal scroll triggers */
                scrollbar-width: none !important; /* Force hide Firefox */
                -ms-overflow-style: none !important;  /* Force hide IE/Edge */
                border: none !important; /* Remove any potential borders */
            }

            .main-nav::-webkit-scrollbar,
            .main-nav::-webkit-scrollbar-thumb,
            .main-nav::-webkit-scrollbar-track {
                display: none !important; /* Force hide Chrome/Safari */
                width: 0 !important;
                height: 0 !important;
                background: transparent !important;
                border: none !important;
            }

            .main-nav.active {
                right: 0;
                visibility: visible;
            }

            .main-nav ul {
                display: flex;
                flex-direction: column;
                width: 100%;
                gap: 0;
                padding: 0;
                margin: 0;
                overflow-y: auto; /* Scrollable menu items */
                flex: 1;
            }

            /* Sidebar Header */
            .main-nav::before {
                content: 'Menu';
                display: block;
                padding: 24px 20px 16px;
                font-size: 14px;
                font-weight: 700;
                color: rgba(255, 255, 255, 0.7);
                text-transform: uppercase;
                letter-spacing: 1.5px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .main-nav li {
                width: 100%;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }

            .main-nav ul li a {
                color: #ffffff !important;
            }

            .main-nav a {
                display: flex;
                align-items: center;
                gap: 16px; /* Increased gap from 12px */
                padding: 16px 20px;
                width: 100%;
                color: rgba(255, 255, 255, 0.9);
                font-size: 15px;
                font-weight: 500;
                transition: all 0.2s ease;
                position: relative;
            }

            .main-nav a::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 4px;
                background: #60a5fa;
                transform: scaleY(0);
                transition: transform 0.2s ease;
            }

            .main-nav a:hover {
                background-color: rgba(255, 255, 255, 0.1);
                color: #ffffff;
                padding-left: 24px;
            }

            .main-nav a:hover::before,
            .main-nav a.active::before {
                transform: scaleY(1);
            }

            .main-nav a.active {
                background-color: rgba(255, 255, 255, 0.12) !important;
                color: #ffffff !important;
                font-weight: 700 !important;
                padding-left: 28px !important;
            }
            
            .main-nav a.active::before {
                transform: scaleY(1) !important;
                background-color: #60a5fa !important;
                width: 5px !important;
            }

            .mobile-logout-item {
                display: block !important;
                width: 100%;
                flex-shrink: 0;
                margin-top: 0 !important;
            }

            .mobile-logout-item button {
                color: #fca5a5 !important;
                font-size: 16px !important;
                font-weight: 700 !important;
                width: 100%;
                text-align: left;
                padding: 16px 20px;
                background: none;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .mobile-logout-item button:hover {
                background-color: rgba(239, 68, 68, 0.1) !important;
                color: #fee2e2 !important;
            }

            .mobile-toggle {
                display: block !important;
                font-size: 1.5rem;
                cursor: pointer;
                color: #333;
                z-index: 1002;
                margin-left: 15px;
                order: 3 !important;
            }

            /* Reorder Layout for Mobile Header */
            .header-actions .profile-avatar-wrapper {
                order: 1 !important; /* Profile first */
            }

            .header-actions .notification-wrapper {
                order: 2 !important; /* Notification second */
                margin-right: 0;
            }

            .mobile-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1000;
            }

            .mobile-overlay.active {
                display: block;
            }

            .logo-container span {
                font-size: 1rem;
            }
        }

        .mobile-toggle {
            display: none;
        }
    </style>
    @yield('styles')
</head>
<body>



    <!-- Modal Overlay untuk Detail Kos -->
    <div class="modal-overlay" id="detailKosModalOverlay">
        <div class="modal-content-wrapper" id="detailKosModalContent">
            <!-- Content will be loaded via AJAX from partial -->
        </div>
    </div>

    <!-- Modal Overlay untuk Hubungi Pemilik -->
    <div class="modal-overlay" id="contactOwnerModalOverlay">
        <div class="modal-content-wrapper" id="contactOwnerModalContent">
            <!-- Content will be loaded via AJAX from partial -->
        </div>
    </div>

    <!-- Modal Overlay untuk Konfirmasi Sewa -->
    <div class="modal-overlay" id="konfirmasiSewaModalOverlay">
        <div class="modal-content-wrapper" id="konfirmasiSewaModalContent">
            <!-- Content will be loaded via AJAX from partial -->
        </div>
    </div>



    <main class="container">
        @if(false)
        <!-- Hero Section Removed to use Dashboard's own banner -->
        @endif

        @yield('content')
    </main>

    <header class="main-header">
        <div class="logo-container">
            <a href="/dashboard-penyewa">
                <i class="fas fa-home"></i>
                <span>KosConnect</span>
            </a>
        </div>
        
        <div class="mobile-overlay" onclick="toggleMobileMenu()"></div>

        <div class="mobile-overlay" onclick="toggleMobileMenu()"></div>

        <nav class="main-nav">
            <ul class="sidebar-links">
                <li><a href="/dashboard-penyewa" class="@yield('active-beranda')"><i class="fas fa-home"></i> Beranda</a></li>
                <li><a href="/wishlist" class="@yield('active-wishlist')"><i class="fas fa-heart"></i> Wishlist</a></li>
                <li><a href="/booking-aktif" class="@yield('active-booking')"><i class="fas fa-calendar-check"></i> Booking & Sewa</a></li>
                <li><a href="/daftarkos" class="@yield('active-daftarKos')"><i class="fas fa-search"></i> Daftar Kos</a></li>
                <li><a href="/review" class="@yield('active-review')"><i class="fas fa-star"></i> Review</a></li>
                <li><a href="/feedback" class="@yield('active-feedback')"><i class="fas fa-comment-alt"></i> Feedback</a></li>
                <li><a href="/pembayaran" class="@yield('active-pembayaran')"><i class="fas fa-credit-card"></i> Pembayaran</a></li>
                <li><a href="/profil-penyewa" class="@yield('active-profil')"><i class="fas fa-user"></i> Profil</a></li>
                <!-- Mobile Logout Link -->
                <li class="mobile-logout-item">
                    <form method="POST" action="/logout-penyewa" style="width: 100%;">
                        @csrf
                        <button type="button" onclick="confirmLogout(this.form)">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <div class="header-actions" style="display: flex; align-items: center; gap: 15px;">
            <div class="notification-wrapper">
                <button class="notification-btn" id="notificationBtn" onclick="toggleNotifications()">
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
                                    <div class="notification-item-container">
                                        @php
                                            $iconClass = 'info';
                                            $icon = 'fa-bell';
                                            if (stripos($notif->tipe, 'booking') !== false) {
                                                $iconClass = 'booking'; $icon = 'fa-calendar-check';
                                            } elseif (stripos($notif->tipe, 'payment') !== false) {
                                                $iconClass = 'payment'; $icon = 'fa-file-invoice-dollar';
                                            } elseif (stripos($notif->tipe, 'rental') !== false) {
                                                $iconClass = 'rental'; $icon = 'fa-clock';
                                            }
                                        @endphp
                                        <div class="notif-icon {{ $iconClass }}">
                                            <i class="fas {{ $icon }}"></i>
                                        </div>
                                        <div class="notification-content">
                                            <div class="notification-title">{{ $notif->judul }}</div>
                                            <div class="notification-message">{{ $notif->pesan }}</div>
                                            <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
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

            <!-- Profile Picture Header -->
            <a href="/profil-penyewa" class="profile-avatar-wrapper">
                @if(session('user.foto_profil'))
                    <img src="{{ session('user.foto_profil') }}" alt="Profile Photo">
                @else
                    <div class="profile-avatar-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
            </a>

            <form method="POST" action="/logout-penyewa" class="desktop-only" style="display: inline;">
                @csrf
                <button type="button" class="btn-logout" onclick="confirmLogout(this.form)">Logout</button>
            </form>

            <div class="mobile-toggle" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function() { // Existing script block start


            // == MODAL DETAIL KOS LOGIC ==
            const modalOverlay = document.getElementById('detailKosModalOverlay');
            const modalContentContainer = document.getElementById('detailKosModalContent');

            // Global function to close modal
            window.closeDetailModal = function() {
                if (modalOverlay) {
                    modalOverlay.classList.remove('show');
                    // Clear content after animation to prevent flashing old content next time
                    setTimeout(() => {
                        modalContentContainer.innerHTML = '';
                    }, 300);
                }
            };

            // Event delegation for "Lihat Detail" buttons only
            document.body.addEventListener('click', function(e) {
                // Find closest anchor tag with btn-detail or btn-dark class (NOT btn-sewa)
                const btnDetail = e.target.closest('a.btn-detail, a.btn-dark');
                
                if (btnDetail && btnDetail.getAttribute('href') && btnDetail.getAttribute('href').includes('/detailKos/')) {
                    e.preventDefault();
                    
                    const url = new URL(btnDetail.getAttribute('href'), window.location.origin).pathname;
                    
                    // Fetch the content
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        modalContentContainer.innerHTML = html;
                        modalOverlay.classList.add('show');
                    })
                    .catch(error => {
                        console.error('Error loading detail kos:', error);
                        alert('Gagal memuat detail kos. Silakan coba lagi.');
                    });
                }

                // Also close modal if clicking outside the content (on the overlay)
                if (e.target === modalOverlay) {
                    window.closeDetailModal();
                }
            });

            // == GLOBAL TOGGLE WISHLIST FUNCTION ==
            window.toggleWishlist = function(kosId) {
                const icon = document.querySelector(`.wishlist-icon[data-kos-id="${kosId}"]`);
                if (!icon) return;
                
                const isActive = icon.classList.contains('active');
                
                // Determine endpoint and method
                const url = isActive ? `/wishlist/remove/${kosId}` : `/wishlist/add/${kosId}`;
                const method = isActive ? 'DELETE' : 'POST';
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                const token = csrfToken ? csrfToken.getAttribute('content') : '';
                
                // Send AJAX request
                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Toggle icon classes
                        if (isActive) {
                            icon.classList.remove('fas', 'active');
                            icon.classList.add('far', 'inactive');
                        } else {
                            icon.classList.remove('far', 'inactive');
                            icon.classList.add('fas', 'active');
                        }
                        
                        // Show notification
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: isActive ? 'success' : 'success',
                            title: isActive ? 'Dihapus dari wishlist' : 'Ditambahkan ke wishlist'
                        });
                        
                        // If on wishlist page, remove the card
                        if (window.location.pathname === '/wishlist' && isActive) {
                            const card = icon.closest('.kos-card');
                            if (card) {
                                card.style.transition = 'all 0.3s ease';
                                card.style.opacity = '0';
                                card.style.transform = 'scale(0.8)';
                                setTimeout(() => {
                                    card.remove();
                                    
                                    // Check if wishlist is empty
                                    const remainingCards = document.querySelectorAll('.kos-card');
                                    if (remainingCards.length === 0) {
                                        const emptyState = document.getElementById('emptyWishlist');
                                        const wishlistGrid = document.getElementById('wishlistGrid');
                                        if (emptyState && wishlistGrid) {
                                            wishlistGrid.style.display = 'none';
                                            emptyState.style.display = 'block';
                                        }
                                    }
                                }, 300);
                            }
                        }
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            };

            // == CONTACT OWNER MODAL LOGIC ==
            const contactModalOverlay = document.getElementById('contactOwnerModalOverlay');
            const contactModalContent = document.getElementById('contactOwnerModalContent');

            // Global function to close contact modal
            window.closeContactModal = function() {
                if (contactModalOverlay) {
                    contactModalOverlay.classList.remove('show');
                    setTimeout(() => {
                        contactModalContent.innerHTML = '';
                    }, 300);
                }
            };

            // Event delegation for "Hubungi" buttons
            document.body.addEventListener('click', function(e) {
                const btnContact = e.target.closest('a.btn-contact, a.btn-success');
                
                if (btnContact && btnContact.getAttribute('href') && btnContact.getAttribute('href').includes('/hubungiPemilik/')) {
                    e.preventDefault();
                    
                    const url = new URL(btnContact.getAttribute('href'), window.location.origin).pathname;
                    
                    // Fetch the content
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        contactModalContent.innerHTML = html;
                        contactModalOverlay.classList.add('show');
                    })
                    .catch(error => {
                        console.error('Error loading contact form:', error);
                        alert('Gagal memuat form kontak. Silakan coba lagi.');
                    });
                }

                // Close modal if clicking outside the content
                if (e.target === contactModalOverlay) {
                    window.closeContactModal();
                }
            });

            // == KONFIRMASI SEWA MODAL LOGIC ==
            const konfirmasiModalOverlay = document.getElementById('konfirmasiSewaModalOverlay');
            const konfirmasiModalContent = document.getElementById('konfirmasiSewaModalContent');

            // Global function to close konfirmasi modal
            window.closeKonfirmasiModal = function() {
                if (konfirmasiModalOverlay) {
                    konfirmasiModalOverlay.classList.remove('show');
                    setTimeout(() => {
                        konfirmasiModalContent.innerHTML = '';
                    }, 300);
                }
            };

            // Event delegation for "Sewa Sekarang" buttons
            document.body.addEventListener('click', function(e) {
                const btnSewa = e.target.closest('a.btn-sewa');
                
                if (btnSewa && btnSewa.getAttribute('href') && btnSewa.getAttribute('href').includes('/tampilKonfirmasiSewa/')) {
                    e.preventDefault();
                    
                    const url = new URL(btnSewa.getAttribute('href'), window.location.origin).pathname;
                    
                    // Fetch the content
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        konfirmasiModalContent.innerHTML = html;
                        konfirmasiModalOverlay.classList.add('show');
                    })
                    .catch(error => {
                        console.error('Error loading konfirmasi sewa:', error);
                        alert('Gagal memuat form konfirmasi. Silakan coba lagi.');
                    });
                }

                // Close modal if clicking outside the content
                if (e.target === konfirmasiModalOverlay) {
                    window.closeKonfirmasiModal();
                }
            });

            // Function to open konfirmasi sewa from detail modal
            window.openKonfirmasiFromDetail = function(kosId) {
                // Close detail modal first
                if (window.closeDetailModal) window.closeDetailModal();
                
                // Wait for detail modal to close, then open konfirmasi modal
                setTimeout(() => {
                    window.openKonfirmasiDirect(kosId);
                }, 300);
            };

            // Function to open konfirmasi sewa directly (e.g. from wishlist)
            window.openKonfirmasiDirect = function(kosId) {
                const url = `/tampilKonfirmasiSewa/${kosId}`;
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    if (konfirmasiModalContent && konfirmasiModalOverlay) {
                        konfirmasiModalContent.innerHTML = html;
                        konfirmasiModalOverlay.classList.add('show');
                    }
                })
                .catch(error => {
                    console.error('Error loading konfirmasi sewa:', error);
                    alert('Gagal memuat form konfirmasi. Silakan coba lagi.');
                });
            };

            // == GLOBAL FUNCTION FOR BOOKING MODAL CALCULATION ==
            window.updateTotalKonfirmasi = function() {
                const durasiSelect = document.getElementById('durasi');
                const totalHargaEl = document.getElementById('total-harga-konfirmasi');
                
                if (!durasiSelect || !totalHargaEl) return;
                
                const durasi = parseInt(durasiSelect.value) || 0;
                // Get price from data attribute
                const hargaPerBulan = parseFloat(durasiSelect.getAttribute('data-harga')) || 0;
                
                if (hargaPerBulan > 0 && durasi > 0) {
                    const total = hargaPerBulan * durasi;
                    const formatted = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(total);
                    totalHargaEl.textContent = formatted;
                } else {
                    totalHargaEl.textContent = 'Rp 0';
                }
            };

            // == GLOBAL SHOW CONTACT MODAL FUNCTION ==
            window.showContactModal = function(nama, telepon) {
                if (!telepon) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Kontak Tidak Tersedia',
                        text: 'Maaf, nomor telepon pemilik belum tersedia.',
                        confirmButtonColor: '#0d6efd'
                    });
                    return;
                }

                // Format phone number to clean version for WA link (remove non-digits)
                // If starts with 08, replace with 628
                let waNumber = telepon.replace(/\D/g, '');
                if (waNumber.startsWith('0')) {
                    waNumber = '62' + waNumber.substring(1);
                }

                Swal.fire({
                    title: 'Hubungi Pemilik',
                    html: `
                        <div style="text-align: center; margin-bottom: 20px;">
                            <i class="fab fa-whatsapp" style="font-size: 48px; color: #25D366; margin-bottom: 10px;"></i>
                            <h4 style="margin: 0; color: #333;">${nama}</h4>
                            <p style="font-size: 18px; color: #555; margin-top: 5px;">${telepon}</p>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: '<i class="fab fa-whatsapp"></i> Chat WhatsApp',
                    cancelButtonText: 'Tutup',
                    confirmButtonColor: '#25D366',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(`https://wa.me/${waNumber}?text=Halo, saya tertarik dengan kos Anda di KosConnect.`, '_blank');
                    }
                });
            };
        });
    </script>
    
    @include('components.sweetalert')
    @yield('scripts')
    <script>
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            const badge = document.querySelector('.notification-badge');
            
            if (!dropdown.classList.contains('active')) {
                // Opening menu, mark as read
                fetch('/notifications/read-all', {
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
    </script>
    <script>
        function toggleMobileMenu() {
            const nav = document.querySelector('.main-nav');
            const overlay = document.querySelector('.mobile-overlay');
            nav.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.classList.toggle('menu-open');
        }
    </script>
</body>
</html>