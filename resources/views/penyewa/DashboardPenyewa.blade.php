<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" href="{{ asset('images/logo-kosconnect.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Penyewa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- CSS VARIABLES & RESET --- */
        :root {
            --primary-blue: #2563eb; 
            --secondary-purple: #6366f1;
            --bg-light: #f3f4f6;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --danger: #ef4444;
            --success: #22c55e;
            --white: #ffffff;
            --border-radius: 8px;
        }

        /* Helper class for desktop-only elements */
        @media (max-width: 768px) {
            .desktop-only {
                display: none !important;
            }
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        html, body {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }

        body { 
            background-color: var(--bg-light); 
            color: var(--text-dark); 
            min-height: 100vh;
            padding-top: 70px;
        }

        body.menu-open {
            overflow: hidden !important;
        }


        .navbar {
            background-color: var(--white);
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

        .logo { font-size: 1.25rem; font-weight: bold; color: var(--primary-blue); display: flex; align-items: center; gap: 0.5rem; }

        /* Main Navigation (Desktop) */
        .main-nav {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            height: 100%;
            align-items: center;
            margin-left: auto;
            margin-right: 1rem;
        }
        
        .main-nav ul {
            display: flex;
            list-style: none;
            gap: 1.5rem;
            height: 100%;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .main-nav li {
            height: 100%;
            display: flex;
            align-items: center;
        }

        .main-nav a {
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none !important;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            height: 100%;
        }

        /* Hide icons in desktop nav and logo links */
        @media (min-width: 769px) {
            .main-nav a i, .logo a i, .sidebar-links a i {
                display: none !important;
            }
        }


        .main-nav a:hover {
            color: var(--primary-blue);
        }

        .main-nav a.active {
            color: var(--primary-blue);
            font-weight: bold;
            border-bottom: 2px solid var(--primary-blue);
        }

        .mobile-logout-item {
            display: none !important;
        }

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

        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }

        /* --- STYLING UMUM (Sama seperti sebelumnya) --- */
        .hero-banner { background-color: var(--primary-blue); color: var(--white); padding: 2rem; border-radius: var(--border-radius); display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .stat-box-purple { background-color: var(--secondary-purple); padding: 1rem 2rem; border-radius: var(--border-radius); text-align: center; min-width: 150px; }
        .stat-box-purple strong { font-size: 2rem; display: block; }
        
        .status-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .status-card { background: var(--white); padding: 1.5rem; border-radius: var(--border-radius); display: flex; align-items: center; gap: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .icon-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
        
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        /* == GRID KARTU KOS (Updated to match Daftar Kos) == */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        .kos-card {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        /* Disable card-wide cursor on mobile to avoid click interception issues */
        @media (max-width: 768px) {
            .kos-card {
                cursor: default;
            }
        }

        .kos-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.15);
            border-color: #0d6efd;
        }

        .kos-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #0d6efd, #6610f2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .kos-card:hover::before {
            transform: scaleX(1);
        }

        .kos-card .card-header {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 22px;
            z-index: 10;
        }
        
        .kos-card .card-header .fa-heart.active {
            color: #dc3545;
        }
        
        .kos-card .card-header .fa-heart.inactive {
            color: #adb5bd;
        }

        .card-img-top {
            height: 200px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #6c757d;
            position: relative;
            overflow: hidden;
        }

        .card-img-top::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.1) 0%, transparent 70%);
        }

        .card-img-top .fa-home {
            font-size: 48px;
            margin-bottom: 12px;
            color: #0d6efd;
            filter: drop-shadow(0 2px 4px rgba(13, 110, 253, 0.3));
        }

        .card-img-top span {
            font-size: 16px;
            font-weight: 500;
            z-index: 1;
            position: relative;
        }
        
        .card-body {
            padding: 20px;
        }

        .card-body h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1e293b;
            line-height: 1.3;
        }

        .rating {
            font-size: 14px;
            color: #f59e0b;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rating span {
            color: #64748b;
            font-weight: 500;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .address {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .price {
            font-size: 18px;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 16px;
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .price small {
            font-weight: 400;
            color: #64748b;
            font-size: 14px;
        }

        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .tags span {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: #475569;
            font-weight: 500;
            border: 1px solid #cbd5e1;
            transition: all 0.2s ease;
        }

        .tags span:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: scale(1.05);
        }

        .card-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 0 20px 20px; /* Aligned with card-body */
        }

        .action-row {
            display: flex;
            gap: 12px;
            width: 100%;
        }

        .card-actions .btn {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            position: relative;
            z-index: 5;
        }
        
        .action-row .btn {
            flex: 1;
        }

        .btn-dark {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
        }

        .btn-dark:hover {
            background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(13, 110, 253, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(25, 135, 84, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #146c43 0%, #0f5132 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(25, 135, 84, 0.4);
        }

        .btn-sewa {
            width: 100%;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
        }

         .btn-sewa:hover {
            background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(13, 110, 253, 0.4);
        }

        /* Search Styling Removed - Replaced by New Styles */

        /* Modal Overlay Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.show {
            display: flex;
            opacity: 1;
        }

        .modal-content-wrapper {
            max-width: 95%;
            width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideIn 0.3s ease;
        }

        .activity-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #e5e7eb;
            margin-top: 3rem;
        }

        .activity-section h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1.5rem;
        }

        .activity-grid {
            display: flex;
            overflow-x: auto;
            gap: 1.5rem;
            padding: 10px 5px 20px;
            margin-bottom: 1rem;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
            -webkit-overflow-scrolling: touch;
        }

        .activity-grid::-webkit-scrollbar {
            height: 6px;
        }

        .activity-grid::-webkit-scrollbar-track {
            background: transparent;
        }

        .activity-grid::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .activity-grid::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .empty-activity-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4rem 2rem;
            min-height: 200px;
        }

        .empty-activity-state p {
            color: #6b7280;
            font-size: 0.95rem;
            margin: 0;
        }

        .activity-card {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            border: 1px solid #e5e7eb;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex: 0 0 320px;
            max-width: 320px;
            min-height: 140px;
        }

        .activity-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.08);
            border-color: var(--primary-blue);
        }

        .activity-card:hover .activity-icon {
            transform: scale(1.05);
        }

        .activity-header {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .activity-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }

        /* Color Variations for Activity Icons */
        .activity-icon.booking { background: #dcfce7; color: #166534; }
        .activity-icon.payment { background: #fef9c3; color: #854d0e; }
        .activity-icon.rental { background: #fee2e2; color: #991b1b; }
        .activity-icon.info { background: #e0f2fe; color: #0369a1; }

        .activity-details {
            flex: 1;
            min-width: 0;
        }

        .activity-details h4 {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
            line-height: 1.3;
        }

        .activity-details p {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 0.75rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .activity-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: auto;
            padding-top: 0.5rem;
            border-top: 1px solid #f1f5f9;
        }

        .status-badge {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: capitalize;
        }
        
        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        /* Notification Styles */
        .notification-wrapper {
            position: relative;
            margin-right: 15px;
            display: inline-block;
        }

        .notification-btn {
            background: none;
            border: none;
            cursor: pointer;
            position: relative;
            color: #64748b;
            font-size: 1.2rem;
            padding: 8px;
            border-radius: 50%;
            transition: background 0.2s;
        }
        
        .notification-btn:hover {
            background-color: #f3f4f6;
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

        /* == FILTER SEARCH STYLES (Copied from Daftar Kos) == */
        .filter-section {
            background: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 40px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        
        /* FIX: SweetAlert Z-Index Issue */
        .swal2-container {
            z-index: 20000 !important;
        }

        .search-bar-container {
            display: flex;
            gap: 20px;
            width: 100%;
            margin-bottom: 0;
        }

        .search-input-wrapper {
            position: relative;
            flex-grow: 1;
        }

        .search-input-wrapper .fa-search {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
        }

        .search-input-wrapper input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .search-input-wrapper input:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .search-bar-container select {
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background-color: #fff;
            font-size: 16px;
            color: #475569;
            min-width: 180px;
            transition: all 0.3s ease;
        }

        .search-bar-container select:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        .btn-search {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 16px 32px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .btn-search:hover {
            background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
        }

        .quick-filter-container {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-top: 24px;
            margin-top: 24px;
            border-top: 1px solid #e2e8f0;
        }

        .quick-filter-label {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            min-width: 100px;
        }

        .filter-tag {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 10px 16px;
            border-radius: 25px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .filter-tag:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .filter-tag.active {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            border-color: #0d6efd;
        }
        .badge-jenis {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }
        
        .badge-jenis.campuran {
            background-color: #e0e7ff;
            color: #4338ca;
            border: 1px solid #c7d2fe;
        }
        
        .badge-jenis.putra {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        
        .badge-jenis.putri {
            background-color: #fce7f3;
            color: #be185d;
            border: 1px solid #fbcfe8;
        }
        .mobile-toggle {
            display: none;
        }

        .mobile-overlay {
            display: none;
        }

        .mobile-logout-form {
            display: none !important;
        }


        @media (max-width: 768px) {
            /* == MOBILE NAVIGATION == */
            .main-nav {
                position: fixed;
                top: 0;
                right: -280px;
                width: 280px;
                height: 100vh;
                margin-right: 0;
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
                visibility: hidden;
                scrollbar-width: none !important;
                -ms-overflow-style: none !important;
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
                height: auto;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }

            .main-nav a {
                color: #ffffff !important;
                padding: 16px 20px;
                font-size: 15px;
                font-weight: 500;
                width: 100%;
                height: auto;
                border-bottom: none;
                text-decoration: none !important;
                position: relative;
                display: flex;
                align-items: center;
                gap: 16px; /* Increased gap from 12px */
            }

            .main-nav a:hover {
                background-color: rgba(255, 255, 255, 0.1);
                color: #ffffff !important;
                padding-left: 24px;
            }

            .main-nav a.active {
                background-color: rgba(255, 255, 255, 0.12) !important;
                color: #ffffff !important;
                font-weight: 700 !important;
                padding-left: 28px !important;
                border-bottom: none !important;
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

            .main-nav a:hover::before,
            .main-nav a.active::before {
                transform: scaleY(1);
            }

            .mobile-logout-item {
                display: block !important;
                width: 100%;
                flex-shrink: 0;
                margin-top: 0 !important; /* Ensure no auto margin is pushing it down */
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

            .mobile-toggle {
                display: block !important;
                font-size: 1.5rem;
                cursor: pointer;
                color: #333;
                z-index: 1002;
                margin-left: 15px;
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

            /* Dashboard Specific Mobile Refinements */
            .container {
                padding: 0 16px;
                margin: 1rem auto;
            }

            .hero-banner {
                flex-direction: column;
                text-align: center;
                gap: 20px;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .hero-banner .hero-text h1 {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }

            .hero-banner .hero-text p {
                font-size: 0.9rem;
            }

            .stat-box-purple {
                width: 100%;
                padding: 1rem;
            }

            .status-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin-bottom: 1.5rem;
            }

            .status-card {
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }

            .status-card .icon-circle {
                width: 48px;
                height: 48px;
                font-size: 1.3rem;
                margin-bottom: 8px;
            }

            .status-card .status-info {
                width: 100%;
            }

            .status-card .status-info h3 {
                font-size: 0.85rem;
                margin-bottom: 4px;
                color: #64748b;
                font-weight: 600;
            }

            .status-card .status-info strong {
                font-size: 1.75rem;
                color: #1e293b;
            }

            .card-grid {
                grid-template-columns: 1fr;
            }

            .filter-section {
                padding: 16px;
                margin-bottom: 24px;
            }

            .filter-section .search-bar-container {
                flex-direction: column;
            }
            
            .search-input-wrapper {
                width: 100%;
            }
            
            select#harga {
                width: 100%;
            }

            .quick-filter-container {
                flex-wrap: wrap;
                overflow-x: visible;
                justify-content: flex-start;
                padding-bottom: 0;
            }
            
            .quick-filter-label {
                width: 100%;
                margin-bottom: 8px;
            }

            .filter-tag {
                white-space: nowrap;
                flex-shrink: 0;
                margin-bottom: 8px;
            }

            .section-header {
                margin-bottom: 1rem;
            }

            .section-header h2 {
                font-size: 1.25rem;
            }

            /* == FIX HEADER ICON ORDER ON MOBILE == */
            .header-actions .mobile-toggle {
                order: 3 !important;
            }
            .header-actions .profile-avatar-wrapper {
                order: 1 !important;
            }
            .header-actions .notification-wrapper {
                order: 2 !important;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <script>
        // Explicitly global functions to avoid ReferenceErrors
        window.toggleMobileMenu = function() {
            const nav = document.querySelector('.main-nav');
            const overlay = document.querySelector('.mobile-overlay');
            if (nav && overlay) {
                nav.classList.toggle('active');
                overlay.classList.toggle('active');
                document.body.classList.toggle('menu-open');
            }
        };

        window.toggleNotifications = function() {
            const dropdown = document.getElementById('notificationDropdown');
            const badge = document.querySelector('.notification-badge');
            
            if (dropdown && !dropdown.classList.contains('active')) {
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
            
            if (dropdown) dropdown.classList.toggle('active');
        };

        window.submitPhoto = function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Sedang mengunggah...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            }
            document.getElementById('profilePhotoForm').submit();
        };

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const wrapper = document.querySelector('.notification-wrapper');
            const dropdown = document.getElementById('notificationDropdown');
            
            if (wrapper && dropdown && !wrapper.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Search Filter Logic
        document.addEventListener('DOMContentLoaded', function() {
            const filterTags = document.querySelectorAll('.filter-tag');
            const selectedFiltersInput = document.getElementById('selectedFilters');
            let selectedFilters = [];

            if (filterTags && selectedFiltersInput) {
                filterTags.forEach(tag => {
                    tag.addEventListener('click', function() {
                        const filterValue = this.getAttribute('data-filter');
                        
                        if (this.classList.contains('active')) {
                            this.classList.remove('active');
                            selectedFilters = selectedFilters.filter(f => f !== filterValue);
                        } else {
                            this.classList.add('active');
                            selectedFilters.push(filterValue);
                        }
                        
                        selectedFiltersInput.value = selectedFilters.join(',');
                        
                        // Auto-submit form for "Quick Filter" behavior
                        const form = document.getElementById('searchForm');
                        if (form) form.submit();
                    });
                });
            }
        });
    </script>

    <nav class="navbar">
        <div class="logo">
            <a href="/dashboard-penyewa" style="cursor: pointer; display: flex; align-items: center; gap: 0.5rem; text-decoration: none; color: inherit;">
                <i class="fas fa-home"></i> KosConnect
            </a>
        </div>
        <div class="mobile-overlay" onclick="toggleMobileMenu()"></div>

        <nav class="main-nav">
            <ul class="sidebar-links">
                <li><a href="/dashboard-penyewa" class="active"><i class="fas fa-home"></i> Beranda</a></li>
                <li><a href="/wishlist"><i class="fas fa-heart"></i> Wishlist</a></li>
                <li><a href="/booking-aktif"><i class="fas fa-calendar-check"></i> Booking & Sewa</a></li>
                <li><a href="/daftarkos"><i class="fas fa-search"></i> Daftar Kos</a></li>
                <li><a href="/review"><i class="fas fa-star"></i> Review</a></li>
                <li><a href="/feedback"><i class="fas fa-comment-alt"></i> Feedback</a></li>
                <li><a href="/pembayaran"><i class="fas fa-credit-card"></i> Pembayaran</a></li>
                <li><a href="/profil-penyewa"><i class="fas fa-user"></i> Profil</a></li>
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
    </nav>

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

    <div class="main-content">
        <div class="container">
            <div class="hero-banner">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div style="position: relative;">
                        <div style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid rgba(255,255,255,0.3); overflow: hidden; background: #fff; display: flex; align-items: center; justify-content: center;">
                            @if(session('user.foto_profil'))
                                <img src="{{ session('user.foto_profil') }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fas fa-user" style="font-size: 32px; color: #cbd5e1;"></i>
                            @endif
                        </div>
                        <label for="profilePhotoInput" style="position: absolute; bottom: -5px; right: -5px; width: 30px; height: 30px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid var(--primary-blue); box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: all 0.2s;">
                            <i class="fas fa-camera" style="font-size: 14px; color: var(--primary-blue);"></i>
                        </label>
                        <form id="profilePhotoForm" action="/update-profil-penyewa-photo" method="POST" enctype="multipart/form-data" style="display: none;">
                            @csrf
                            <input type="file" id="profilePhotoInput" name="photo" accept="image/*" onchange="submitPhoto()">
                        </form>
                    </div>
                    <div class="hero-text" style="text-align: left;">
                        <h1>Selamat datang {{ session('user.name') }}!</h1>
                        <p>Temukan kos impian Anda dengan mudah dan nyaman</p>
                    </div>
                </div>
                <div class="stat-box-purple">
                    <span>Kos Tersedia</span>
                    <strong>{{ $totalKosTersedia ?? 0 }}</strong>
                </div>
            </div>

            <div class="status-grid">
                <div class="status-card">
                    <div class="icon-circle" style="background: #dcfce7; color: #16a34a;"><i class="fas fa-check"></i></div>
                    <div class="status-info"><h3>Kos Aktif</h3><strong>{{ $kosAktif ?? 0 }}</strong></div>
                </div>
                <div class="status-card">
                    <div class="icon-circle" style="background: #fef9c3; color: #ca8a04;"><i class="fas fa-folder"></i></div>
                    <div class="status-info"><h3>Pembayaran Pending</h3><strong>{{ $pembayaranPending ?? 0 }}</strong></div>
                </div>
                <div class="status-card">
                    <div class="icon-circle" style="background: #dbeafe; color: #2563eb;"><i class="fas fa-envelope"></i></div>
                    <div class="status-info"><h3>Pesan Baru</h3><strong>{{ $pesanBaru ?? 0 }}</strong></div>
                </div>
                <div class="status-card">
                    <div class="icon-circle" style="background: #f3f4f6; color: #ef4444;"><i class="fas fa-heart"></i></div>
                    <div class="status-info"><h3>Wishlist</h3><strong>{{ $wishlistCount ?? 0 }}</strong></div>
                </div>
                <div class="status-card">
                    <div class="icon-circle" style="background: #ffedd5; color: #ea580c;"><i class="fas fa-history"></i></div>
                    <div class="status-info"><h3>Booking Aktif</h3><strong>{{ $bookingAktif ?? 0 }}</strong></div>
                </div>
            </div>

            <section class="filter-section">
                <form action="/daftarkos" method="GET" id="searchForm">
                    <div class="search-bar-container">
                        <div class="search-input-wrapper">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search" placeholder="Cari kos berdasarkan nama, lokasi, atau fasilitas..">
                        </div>
                        <select name="harga" id="harga">
                            <option value="semua">Semua Harga</option>
                            <option value="murah">Rp 0 - Rp 1.000.000</option>
                            <option value="menengah">Rp 1.000.000 - Rp 2.000.000</option>
                        </select>
                        <input type="hidden" name="fasilitas" id="selectedFilters">
                        <button type="submit" class="btn-search">
                            <i class="fas fa-search"></i> Cari Kos
                        </button>
                    </div>
                </form>

                <div class="quick-filter-container">
                    <span class="quick-filter-label">Filter Cepat:</span>
                    <button type="button" class="filter-tag" data-filter="wifi">
                        <i class="fas fa-wifi"></i> WiFi
                    </button>
                    <button type="button" class="filter-tag" data-filter="ac">
                        <i class="fas fa-snowflake"></i> AC
                    </button>
                    <button type="button" class="filter-tag" data-filter="kamar_mandi_dalam">
                        <i class="fas fa-bed"></i> Kamar Mandi Dalam
                    </button>
                    <button type="button" class="filter-tag" data-filter="parkir">
                        <i class="fas fa-car"></i> Parkir
                    </button>
                </div>
            </section>

            <div class="section-header">
                <h2>Rekomendasi Kos</h2>
                <a href="/daftarkos" style="color: var(--primary-blue); text-decoration: none;">Lihat Semua →</a>
            </div>

            <div class="card-grid">
                @forelse($kosList as $kos)
                <div class="kos-card">
                    <div class="card-header">
                        @php
                            $isWishlisted = in_array($kos->id, $wishlistKosIds ?? []);
                        @endphp
                        <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart {{ $isWishlisted ? 'active' : 'inactive' }} wishlist-icon" 
                           data-kos-id="{{ $kos->id }}" 
                           onclick="toggleWishlist({{ $kos->id }})"></i>
                    </div>
                    <div class="card-img-top">
                        @if($kos->gambar)
                            <img src="{{ $kos->gambar_url }}" alt="{{ $kos->nama_kos }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fas fa-home"></i>
                            <span>Foto Kos</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h3>{{ $kos->nama_kos }}</h3>
                        <div class="rating">
                            @php
                                $avgRating = $kos->reviews_avg_rating ?? $kos->reviews->avg('rating') ?? 0;
                                $fullStars = floor($avgRating);
                                $halfStar = ($avgRating - $fullStars) >= 0.5;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <i class="fas fa-star"></i>
                                @elseif($i == $fullStars + 1 && $halfStar)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <span>({{ number_format($avgRating, 1) }})</span>
                        </div>
                        <div style="margin-bottom: 8px;">
                            <span class="badge-jenis {{ $kos->jenis_kos }}">{{ ucfirst($kos->jenis_kos) }}</span>
                        </div>
                        <p class="address">{{ $kos->alamat }}</p>
                        <p class="price">Rp {{ number_format($kos->harga_dasar, 0, ',', '.') }} <small>/Bulan</small></p>
                        <div class="tags">
                            @if(is_array($kos->fasilitas) && count($kos->fasilitas) > 0)
                                @foreach(array_slice($kos->fasilitas, 0, 3) as $fas)
                                    <span>{{ $fas }}</span>
                                @endforeach
                            @elseif(is_string($kos->fasilitas) && !empty($kos->fasilitas))
                                @foreach(array_slice(explode(',', $kos->fasilitas), 0, 3) as $fas)
                                    <span>{{ trim($fas) }}</span>
                                @endforeach
                            @else
                                <span style="background: none; border: none; color: #94a3b8; font-style: italic;">Tidak ada fasilitas</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-actions">
                        <div class="action-row">
                            <a href="{{ url('/detailKos/' . $kos->id) }}" class="btn btn-dark">Lihat Detail</a>
                            <a href="{{ url('/hubungiPemilik/' . $kos->id) }}" class="btn btn-success">Hubungi</a>
                        </div>
                        <a href="{{ url('/tampilKonfirmasiSewa/' . $kos->id) }}" class="btn btn-sewa">Sewa Sekarang</a>
                    </div>
                </div>
                @empty
                <div class="empty-state" style="grid-column: 1/-1;">
                    <p>Belum ada rekomendasi kos.</p>
                </div>
                @endforelse
            </div>

            <!-- Aktivitas Terbaru Section -->
            <div class="activity-section">
                <h2>Aktivitas Terbaru</h2>
                @if(isset($notifications) && count($notifications) > 0)
                <div class="activity-grid">
                    @foreach($notifications as $notif)
                    <div class="activity-card" onclick="window.location.href='{{ $notif->link ?? '#' }}'" style="cursor: pointer;">
                        <div class="activity-header">
                            <div class="activity-icon 
                                @if(stripos($notif->tipe, 'booking') !== false) booking
                                @elseif(stripos($notif->tipe, 'payment') !== false) payment
                                @elseif(stripos($notif->tipe, 'rental') !== false) rental
                                @else info @endif">
                                
                                @if(stripos($notif->tipe, 'booking') !== false)
                                    <i class="fas fa-calendar-check"></i>
                                @elseif(stripos($notif->tipe, 'payment') !== false)
                                    <i class="fas fa-file-invoice-dollar"></i>
                                @elseif(stripos($notif->tipe, 'rental') !== false)
                                    <i class="fas fa-clock"></i>
                                @else
                                    <i class="fas fa-bell"></i>
                                @endif
                            </div>
                            <h4>{{ $notif->judul }}</h4>
                        </div>
                        <div class="activity-details">
                            <p>{{ $notif->pesan }}</p>
                        </div>
                        <div class="activity-meta">
                            <span>{{ $notif->created_at->diffForHumans() }}</span>
                            @if(!$notif->is_read)
                                <span class="status-badge" style="background: #eff6ff; color: #3b82f6; font-size: 0.7rem; padding: 3px 8px;">Baru</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-activity-state">
                    <p>Belum Ada Aktivitas Terbaru</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Toggle Wishlist Function
        function toggleWishlist(kosId) {
            const icon = document.querySelector(`.wishlist-icon[data-kos-id="${kosId}"]`);
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
                    
                    // Update wishlist counter in status card
                    const wishlistCounter = document.querySelector('.status-card:nth-child(4) strong');
                    if (wishlistCounter) {
                        const currentCount = parseInt(wishlistCounter.textContent);
                        wishlistCounter.textContent = isActive ? currentCount - 1 : currentCount + 1;
                    }
                    
                    // Show success message (optional)
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
                        icon: 'success',
                        title: isActive ? 'Dihapus dari wishlist' : 'Ditambahkan ke wishlist'
                    });
                } else {
                    console.error('Error:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }

        // == MODAL HANDLERS ==
        const detailModalOverlay = document.getElementById('detailKosModalOverlay');
        const detailModalContent = document.getElementById('detailKosModalContent');
        const contactModalOverlay = document.getElementById('contactOwnerModalOverlay');
        const contactModalContent = document.getElementById('contactOwnerModalContent');
        const konfirmasiModalOverlay = document.getElementById('konfirmasiSewaModalOverlay');
        const konfirmasiModalContent = document.getElementById('konfirmasiSewaModalContent');

        // Close functions
        window.closeDetailModal = function() {
            if (detailModalOverlay) {
                detailModalOverlay.classList.remove('show');
                setTimeout(() => { detailModalContent.innerHTML = ''; }, 300);
            }
        };

        window.closeContactModal = function() {
            if (contactModalOverlay) {
                contactModalOverlay.classList.remove('show');
                setTimeout(() => { contactModalContent.innerHTML = ''; }, 300);
            }
        };

        window.closeKonfirmasiModal = function() {
            if (konfirmasiModalOverlay) {
                konfirmasiModalOverlay.classList.remove('show');
                setTimeout(() => { konfirmasiModalContent.innerHTML = ''; }, 300);
            }
        };

        window.openKonfirmasiFromDetail = function(kosId) {
            window.closeDetailModal();
            setTimeout(() => {
                fetch(`/tampilKonfirmasiSewa/${kosId}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    konfirmasiModalContent.innerHTML = html;
                    konfirmasiModalOverlay.classList.add('show');
                });
            }, 300);
        };

        // Event delegation for buttons
        document.body.addEventListener('click', function(e) {
            // Detail Kos button
            const btnDetail = e.target.closest('a.btn-dark');
            if (btnDetail && btnDetail.getAttribute('href') && btnDetail.getAttribute('href').includes('/detailKos/')) {
                e.preventDefault();
                const url = new URL(btnDetail.getAttribute('href'), window.location.origin).pathname;
                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    detailModalContent.innerHTML = html;
                    detailModalOverlay.classList.add('show');
                });
            }

            // Contact Owner button
            const btnContact = e.target.closest('a.btn-success');
            if (btnContact && btnContact.getAttribute('href') && btnContact.getAttribute('href').includes('/hubungiPemilik/')) {
                e.preventDefault();
                const url = new URL(btnContact.getAttribute('href'), window.location.origin).pathname;
                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    contactModalContent.innerHTML = html;
                    contactModalOverlay.classList.add('show');
                });
            }

            // Sewa Sekarang button
            const btnSewa = e.target.closest('a.btn-sewa');
            if (btnSewa && btnSewa.getAttribute('href') && btnSewa.getAttribute('href').includes('/tampilKonfirmasiSewa/')) {
                e.preventDefault();
                const url = new URL(btnSewa.getAttribute('href'), window.location.origin).pathname;
                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    konfirmasiModalContent.innerHTML = html;
                    konfirmasiModalOverlay.classList.add('show');
                });
            }

            // Close modals when clicking outside
            if (e.target === detailModalOverlay) window.closeDetailModal();
            if (e.target === contactModalOverlay) window.closeContactModal();
            if (e.target === konfirmasiModalOverlay) window.closeKonfirmasiModal();
        });
        // == GLOBAL FUNCTION TO UPDATE ROOM SELECTION ==
        window.updateRoomSelection = function() {
            const kamarSelect = document.getElementById('kamar_id');
            const durasiSelect = document.getElementById('durasi');
            if (!kamarSelect || !durasiSelect) return;

            const selectedOption = kamarSelect.options[kamarSelect.selectedIndex];
            if (!selectedOption) return;

            const harga = selectedOption.getAttribute('data-harga');
            
            durasiSelect.setAttribute('data-harga', harga);
            
            // Trigger price update
            if (typeof window.updateTotalKonfirmasi === 'function') {
                window.updateTotalKonfirmasi();
            }
        };

        // == GLOBAL FUNCTION FOR BOOKING MODAL CALCULATION ==
        window.updateTotalKonfirmasi = function() {
            const durasiSelect = document.getElementById('durasi');
            const totalHargaEl = document.getElementById('total-harga-konfirmasi');
            
            if (!durasiSelect || !totalHargaEl) return;
            
            const durasi = parseInt(durasiSelect.value) || 0;
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

            // Format phone number to clean version for WA link
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

        // == WISHLIST TOGGLE FUNCTION ==
        window.toggleWishlist = function(kosId) {
            // Find the heart icon element
            const icon = document.querySelector(`.wishlist-icon[data-kos-id="${kosId}"]`);
            if (!icon) return;

            fetch('/toggle-wishlist', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ kos_id: kosId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' || data.success) {
                    // Toggle classes
                    if (data.action === 'added') {
                        icon.classList.remove('far', 'inactive');
                        icon.classList.add('fas', 'active');
                    } else {
                        icon.classList.remove('fas', 'active');
                        icon.classList.add('far', 'inactive');
                    }
                    
                    // Show small notification
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                } else {
                    Swal.fire('Error', data.message || 'Gagal mengubah wishlist', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
            });
        };
    </script>

    @include('components.sweetalert')
</body>
</html>
