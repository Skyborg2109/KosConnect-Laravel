@extends('penyewa.layout')

@section('title', 'Menunggu Konfirmasi')

@section('active-booking', 'active')

@section('styles')
<style>
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
        flex-wrap: nowrap;
        border-bottom: 1px solid #e9ecef;
        background-color: #f8f9fa;
        overflow-x: auto;
        overflow-y: hidden;
        scrollbar-width: thin; /* Firefox */
        -ms-overflow-style: auto;  
        -webkit-overflow-scrolling: touch;
        cursor: grab;
        user-select: none;
        width: 100%;
    }
    
    .tab-nav:active {
        cursor: grabbing;
    }
    
    .tab-nav::-webkit-scrollbar {
        height: 4px;
    }
    
    .tab-nav::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    
    .tab-nav a {
        padding: 14px 24px;
        font-size: 16px;
        font-weight: 500;
        color: #6c757d;
        border-bottom: 3px solid transparent;
        margin-bottom: -1px;
        white-space: nowrap;
        text-decoration: none;
        flex-shrink: 0;
    }
    
    .tab-nav a.active {
        color: #0d6efd;
        font-weight: 600;
        border-bottom-color: #0d6efd;
        background-color: #ffffff;
    }
    
    .tab-content {
        padding: 30px;
        min-height: 250px;
    }

    /* KONTEN TAB "MENUNGGU KONFIRMASI" */
    .booking-details-card {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 24px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        width: 100%;
        margin-bottom: 20px;
    }

    .tab-content .booking-details-card:last-child {
        margin-bottom: 0;
    }

    .booking-info h4 { font-size: 18px; font-weight: 600; margin-bottom: 4px; }
    .booking-info .address, .booking-info .date-info, .booking-duration .date-info { 
        font-size: 14px; 
        color: #555; 
        margin-bottom: 4px; 
    }
    .booking-info .price { font-size: 16px; font-weight: 700; color: #0d6efd; margin-top: 12px; }
    .booking-duration {
        flex-shrink: 0;
        margin: 0 40px;
    }

    .details-row {
        display: flex;
        gap: 30px;
        margin-top: 15px;
    }

    .info-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-group label {
        font-size: 12px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-group span {
        font-size: 14px;
        font-weight: 500;
        color: #334155;
    }

    .price-row {
        display: block;
    }

    .price-row .price-label {
        font-size: 12px;
        color: #64748b;
        display: block;
        margin-bottom: 2px;
    }
    .booking-actions { text-align: right; margin-left: auto; align-self: center; }
    .action-buttons { display: flex; gap: 10px; justify-content: flex-end; align-items: stretch; }
    .action-buttons form { margin: 0; display: flex; }

    .status-tag {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 16px;
    }
    
    .status-tag.pending {
        background-color: #fef9c3;
        color: #ca8a04;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        gap: 8px;
    }

    .btn:active {
        transform: scale(0.98);
    }
    
    .btn-pay {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }
    
    .btn-cancel {
        background-color: #ef4444;
        color: #ffffff;
    }

    /* Status Tag Refinement */
    .status-tag {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-bottom: 0px;
    }

    /* 2. GRID KARTU AKSI BAWAH */
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
        min-height: 180px;
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
        text-decoration: none;
    }
    
    .info-card .card-icon {
        font-size: 40px;
        position: absolute;
        bottom: 24px;
        right: 24px;
        opacity: 0.8;
    }

    /* == RESPONSIVE MOBILE == */
    @media (max-width: 768px) {
        .tab-nav {
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            display: flex;
            scrollbar-width: thin;
            -webkit-overflow-scrolling: touch;
            border-bottom: 1px solid #e9ecef;
        }
        .tab-nav::-webkit-scrollbar { 
            height: 3px;
            display: block; 
        }
        .tab-nav a { 
            flex: 0 0 auto;
            padding: 12px 16px;
            font-size: 14px;
        }

        .booking-details-card {
            flex-direction: column;
            gap: 15px;
            padding: 16px;
            border-radius: 12px;
            display: block;
        }

        .booking-info h4 {
            font-size: 17px;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .booking-info .address {
            font-size: 13px;
            margin-bottom: 12px;
            display: block;
        }

        .details-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 15px;
        }

        .info-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .info-group label {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
        }

        .info-group span {
            font-size: 13px;
            font-weight: 500;
            color: #334155;
        }

        .booking-duration {
            display: none;
        }

        .booking-actions {
            text-align: left;
            margin-left: 0;
            width: 100%;
            padding-top: 15px;
            border-top: 1px solid #f1f5f9;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .price-row .price-label {
            font-size: 13px;
            color: #64748b;
        }

        .price-row .price-value {
            font-size: 1.1rem !important;
            font-weight: 700;
            color: #0d6efd;
            margin: 0 !important;
        }

        .btn {
            padding: 12px;
            font-size: 14px;
            width: 100%;
            border-radius: 8px;
        }

        .bottom-cards-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .info-card {
            min-height: auto;
            padding: 20px;
            align-items: center;
            text-align: center;
        }

        .info-card p {
            max-width: 100%;
            margin-bottom: 15px;
        }

        .info-card .card-icon {
            display: none;
        }

        .btn-card {
            width: 100%;
            margin-top: 0;
            padding: 12px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-self: center;
            border-radius: 8px;
        }
    }

        .tab-nav {
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            display: flex;
            scrollbar-width: thin;
            -webkit-overflow-scrolling: touch;
            border-bottom: 1px solid #e9ecef;
        }
        .tab-nav::-webkit-scrollbar { 
            height: 3px;
            display: block; 
        }
        .tab-nav a { 
            flex: 0 0 auto;
            padding: 12px 16px;
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')
    <h1 class="page-title">Booking Kos/Kamar</h1>

    <section class="booking-container">
        <nav class="tab-nav">
            <a href="/booking-aktif">Booking Aktif</a>
            <a href="/menunggu-konfirmasi" class="active">Menunggu Konfirmasi</a> 
            <a href="/menunggu-pembayaran">Menunggu Pembayaran</a>
            <a href="/riwayat-booking">Riwayat Booking</a>
        </nav>
        <div class="tab-content" id="menunggu-konfirmasi">
            @forelse($bookings as $booking)
            <div class="booking-details-card">
                <div class="booking-info">
                    <h4>{{ $booking->kamar?->kos?->nama_kos ?? 'Nama Kos Tidak Tersedia' }}</h4>
                    <p class="address"><i class="fas fa-map-marker-alt" style="margin-right: 5px; color: #64748b;"></i> {{ $booking->kamar?->kos?->alamat ?? 'Alamat tidak tersedia' }}</p>
                    
                    <div class="details-row">
                        <div class="info-group">
                            <label>Check-in</label>
                            <span>{{ $booking->tanggal_mulai ? \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="info-group">
                            <label>Durasi</label>
                            <span>{{ $booking->durasi_bulan ?? 0 }} bulan</span>
                        </div>
                        <div class="info-group">
                            <label>Check-out</label>
                            @php
                                $startDate = $booking->tanggal_mulai ? \Carbon\Carbon::parse($booking->tanggal_mulai) : null;
                                $checkoutDate = $startDate ? $startDate->copy()->addMonths((int)($booking->durasi_bulan ?? 0)) : null;
                            @endphp
                            <span>{{ $checkoutDate ? $checkoutDate->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="info-group">
                            <label>Tgl Booking</label>
                            <span>{{ $booking->created_at ? $booking->created_at->format('d/m/Y') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="booking-actions">
                    <div class="price-row">
                        <span class="price-label">Biaya Sewa</span>
                        <p class="price-value">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; width: 100%;">
                        @if($booking->status == 'menunggu_konfirmasi')
                            <span class="status-tag pending" style="background-color: #e2e3e5; color: #383d41;">
                                <i class="fas fa-clock" style="margin-right: 5px;"></i> Menunggu Konfirmasi Pemilik
                            </span>
                        @endif
                    </div>

                    <div class="action-buttons">
                        <form action="/booking/cancel/{{ $booking->id }}" method="POST" id="cancelForm{{ $booking->id }}">
                            @csrf
                            <button type="button" class="btn btn-cancel" onclick="confirmCancel({{ $booking->id }})">
                                <i class="fas fa-times-circle"></i> Batalkan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state" style="text-align: center; color: #6c757d; padding: 40px;">
                <div class="icon-wrapper" style="font-size: 28px; color: #ffffff; background-color: #adb5bd; width: 60px; height: 60px; border-radius: 50%; display: grid; place-items: center; margin: 0 auto 16px;">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <p>Tidak ada booking yang menunggu konfirmasi</p>
            </div>
            @endforelse
        </div>
    </section>

    <section class="bottom-cards-grid">
        <article class="info-card blue">
            <div>
                <h3>Booking Baru</h3>
                <p>Cari dan booking kos impian Anda</p>
            </div>
            <a href="/daftarkos" class="btn-card">Cari Kos</a>
            <i class="fas fa-home card-icon"></i>
        </article>
        
        <article class="info-card green">
            <div>
                <h3>Pembayaran</h3>
                <p>Kelola pembayaran booking Anda</p>
            </div>
            <a href="/pembayaran" class="btn-card">Lihat Pembayaran</a>
            <i class="fas fa-file-invoice card-icon"></i>
        </article>
        
        <article class="info-card purple">
            <div>
                <h3>Bantuan</h3>
                <p>Butuh bantuan dengan booking?</p>
            </div>
            <a href="/feedback" class="btn-card">Hubungi CS</a>
            <i class="fas fa-question card-icon"></i>
        </article>
    </section>

    <script>

        // DRAG TO SCROLL FOR TABS (Desktop Only)
        document.addEventListener('DOMContentLoaded', function() {
            const tabNav = document.querySelector('.tab-nav');
            if (tabNav && window.matchMedia('(pointer: fine)').matches) {
                let isDown = false;
                let scrollLeft;
                let startX;

                tabNav.addEventListener('mousedown', (e) => {
                    isDown = true;
                    tabNav.classList.add('active');
                    startX = e.pageX - tabNav.offsetLeft;
                    scrollLeft = tabNav.scrollLeft;
                });

                tabNav.addEventListener('mouseleave', () => {
                    isDown = false;
                });

                tabNav.addEventListener('mouseup', () => {
                    isDown = false;
                });

                tabNav.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - tabNav.offsetLeft;
                    const walk = (x - startX) * 2;
                    tabNav.scrollLeft = scrollLeft - walk;
                });
            }
        });

        function confirmCancel(id) {
            Swal.fire({
                title: 'Batalkan Booking?',
                text: "Apakah Anda yakin ingin membatalkan booking ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancelForm' + id).submit();
                }
            });
        }
    </script>
@endsection