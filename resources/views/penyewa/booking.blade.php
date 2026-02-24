@extends('penyewa.layout')

@section('title', 'Booking Kos/Kamar')

@section('active-booking', 'active')

@section('styles')
<style>
        /* == CSS RESET & DASAR == */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
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
        
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }


        /* == CSS HALAMAN BOOKING == */

        .page-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        /* 1. KOTAK TAB BOOKING */
        .booking-container {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .tab-nav {
            display: flex;
            border-bottom: 1px solid #e9ecef;
            background-color: #f8f9fa;
        }
        
        .tab-nav a {
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 500;
            color: #6c757d;
            border-bottom: 3px solid transparent;
            margin-bottom: -1px;
        }
        
        .tab-nav a.active {
            color: #0d6efd;
            font-weight: 600;
            border-bottom-color: #0d6efd;
            background-color: #ffffff;
        }
        
        .tab-content {
            padding: 30px; /* Padding disesuaikan */
            min-height: 200px;
            /* Dihilangkan: 'display: grid' & 'place-items: center' */
        }

        /* KONTEN TAB "MENUNGGU KONFIRMASI" BARU */
        .booking-details-card {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* Konten rata atas */
            padding: 24px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        
        .booking-info h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .booking-info .address,
        .booking-info .date-info,
        .booking-duration .date-info {
            font-size: 14px;
            color: #555;
            margin-bottom: 4px;
        }
        
        .booking-info .price {
            font-size: 16px;
            font-weight: 700;
            color: #0d6efd; /* Biru */
            margin-top: 12px;
        }
        
        .booking-duration {
            /* Kolom ini ada di tengah */
            flex-shrink: 0;
            margin: 0 40px;
        }
        
        .booking-actions {
            text-align: right;
            margin-left: auto; /* Mendorong ke paling kanan */
        }
        
        .status-tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 16px;
        }
        
        .status-tag.pending {
            background-color: #fef9c3; /* Kuning muda */
            color: #ca8a04; /* Kuning tua */
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-pay {
            background-color: #0d6efd; /* Biru */
            color: #ffffff;
        }
        
        .btn-cancel {
            background-color: #dc3545; /* Merah */
            color: #ffffff;
        }

        
        /* 2. GRID KARTU AKSI BAWAH (VERSI UPDATE) */
        .bottom-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        
        .info-card {
            padding: 24px;
            border-radius: 8px;
            color: #ffffff;
            position: relative;
            min-height: 180px; /* Sedikit lebih tinggi */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .info-card.blue { background-color: #0d6efd; }
        .info-card.green { background-color: #198754; }
        .info-card.purple { background-color: #6f42c1; }
        
        .info-card h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .info-card p {
            font-size: 14px;
            opacity: 0.9;
            max-width: 80%;
        }

        .btn-card {
            background-color: #ffffff;
            color: #212529;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            margin-top: 16px;
            align-self: flex-start;
        }
        
        .info-card .card-icon {
            font-size: 40px; /* Sedikit lebih besar */
            position: absolute;
            bottom: 24px;
            right: 24px;
            opacity: 0.8;
        }

        /* == MOBILE RESPONSIVE == */
        @media (max-width: 768px) {
            .booking-details-card {
                flex-direction: column;
                gap: 15px;
            }

            .booking-duration {
                margin: 0;
            }

            .booking-actions {
                text-align: left;
                margin-left: 0;
                width: 100%;
                margin-top: 15px;
            }

            .bottom-cards-grid {
                grid-template-columns: 1fr;
            }
            
            .tab-nav {
                flex-direction: column;
            }
            
            .tab-nav a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
        
        <h1 class="page-title">Booking Kos/Kamar</h1>

        <section class="booking-container">
            <nav class="tab-nav">
                <a href="/booking-aktif">Booking Aktif</a>
                <a href="/menunggu-konfirmasi">Menunggu Konfirmasi</a>
                <a href="/riwayat-booking" class="active">Riwayat Booking</a>
            </nav>
            
            <div class="tab-content">
                
                <div class="empty-state">
                    <div class="icon-wrapper">
                        <i class="fas fa-check"></i>
                    </div>
                    <p>Belum ada booking aktif</p>
                </div>
                
                </div>

            
        </section>

        <section class="bottom-cards-grid">
            
            <article class="info-card blue">
                <div>
                    <h3>Booking Baru</h3>
                    <p>Cari dan booking kos impian Anda</p>
                </div>
                <button class="btn-card">Cari Kos</button>
                <i class="fas fa-home card-icon"></i>
            </article>
            
            <article class="info-card green">
                <div>
                    <h3>Pembayaran</h3>
                    <p>Kelola pembayaran booking Anda</p>
                </div>
                <button class="btn-card">Lihat Pembayaran</button>
                <i class="fas fa-file-invoice-dollar card-icon"></i>
            </article>
            
            <article class="info-card purple">
                <div>
                    <h3>Bantuan</h3>
                    <p>Butuh bantuan dengan booking?</p>
                </div>
                <button class="btn-card">Hubungi CS</button>
                <i class="fas fa-question-circle card-icon"></i>
            </article>
            
        </section>

@endsection