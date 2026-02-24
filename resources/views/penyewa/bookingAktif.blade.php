@extends('penyewa.layout')

@section('title', 'Booking Aktif')

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
        height: 4px; /* Thin horizontal scrollbar */
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

    /* KONTEN TAB */
    .booking-details-card {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 24px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        width: 100%;
        margin-bottom: 20px;
        background-color: #fff;
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
    .btn-pay:hover { background-color: #0b5ed7; transform: translateY(-1px); }
    
    .btn-cancel {
        background-color: #ef4444;
        color: #ffffff;
    }
    .btn-cancel:hover { background-color: #dc2626; transform: translateY(-1px); }

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

    /* == BOTTOM INFO CARDS == */
    .bottom-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Flexible grid */
        gap: 20px;
        margin-top: 30px;
    }
    
    .info-card {
        padding: 24px;
        border-radius: 12px;
        color: #ffffff;
        position: relative;
        min-height: 180px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .info-card.blue { background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%); }
    .info-card.green { background: linear-gradient(135deg, #198754 0%, #146c43 100%); }
    .info-card.purple { background: linear-gradient(135deg, #6f42c1 0%, #59359a 100%); }
    
    .info-card h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
        position: relative;
        z-index: 2;
    }
    
    .info-card p {
        font-size: 14px;
        opacity: 0.9;
        max-width: 80%;
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
    }

    .btn-card {
        background-color: rgba(255, 255, 255, 0.9);
        color: #212529;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        align-self: flex-start;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        position: relative;
        z-index: 2;
    }

    .btn-card:hover {
        background-color: #ffffff;
        transform: scale(1.05);
    }
    
    .info-card .card-icon {
        font-size: 80px;
        position: absolute;
        bottom: -10px;
        right: -10px;
        opacity: 0.15;
        transform: rotate(-15deg);
        z-index: 1;
    }

    /* == MODAL STYLES == */
    .modal-overlay {
        display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100vh;
        background-color: rgba(0, 0, 0, 0.5); z-index: 9999;
        justify-content: center; align-items: center;
        opacity: 0; transition: opacity 0.3s ease;
    }
    .modal-overlay.show { display: flex; opacity: 1; }
    .modal-content {
        background-color: white; padding: 30px; border-radius: 8px; width: 90%; max-width: 500px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1); transform: translateY(-20px); transition: transform 0.3s ease;
    }
    .modal-overlay.show .modal-content { transform: translateY(0); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .modal-title { font-size: 18px; font-weight: 600; color: #333; }
    .close-btn { background: none; border: none; font-size: 24px; cursor: pointer; color: #999; }
    .close-btn:hover { color: #333; }
    .info-box { background-color: #f8f9fa; padding: 15px; border-radius: 6px; font-size: 14px; color: #555; margin-bottom: 20px; border: 1px solid #e9ecef; }
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; color: #495057; }
    .form-control { width: 100%; padding: 10px 12px; border: 1px solid #ced4da; border-radius: 6px; font-size: 14px; }
    .total-section { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; margin-bottom: 25px; padding-top: 20px; border-top: 1px solid #eee; }
    .total-label { font-weight: 700; font-size: 16px; color: #333; }
    .total-amount { font-size: 20px; font-weight: 700; color: #0d6efd; }
    .modal-actions { display: flex; gap: 12px; justify-content: flex-end; }
    
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
            display: none; /* Already handled by details-row in this layout */
        }

        .booking-actions {
            text-align: left;
            margin-left: 0;
            width: 100%;
            padding-top: 15px;
            border-top: 1px solid #f1f5f9;
        }

        .action-buttons {
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .action-buttons form {
            width: 100%;
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
</style>
@endsection

@section('content')
    <h1 class="page-title">Booking Kos/Kamar</h1>

    <section class="booking-container">
        <nav class="tab-nav">
            <a href="/booking-aktif" class="active">Booking Aktif</a> 
            <a href="/menunggu-konfirmasi">Menunggu Konfirmasi</a>
            <a href="/menunggu-pembayaran">Menunggu Pembayaran</a>
            <a href="/riwayat-booking">Riwayat Booking</a>
        </nav>
        
        <div class="tab-content">
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
                            <span>{{ $booking->durasi_bulan ?? 0 }} Bulan</span>
                        </div>
                        <div class="info-group">
                            <label>Tgl Berakhir</label>
                            <span>{{ $booking->tanggal_selesai ? $booking->tanggal_selesai->format('d/m/Y') : '-' }}</span>
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
                        @if($booking->status == 'aktif')
                            <span class="status-tag aktif" style="background-color: #d1fae5; color: #059669;">
                                <i class="fas fa-check-circle" style="margin-right: 5px;"></i> SEWA AKTIF
                            </span>
                        @else
                            <span class="status-tag pending" style="background-color: #fef3c7; color: #92400e;">
                                <i class="fas fa-clock" style="margin-right: 5px;"></i> MENUNGGU KONFIRMASI
                            </span>
                        @endif
                    </div>
                        
                    <div class="action-buttons">
                            @if($booking->status == 'aktif')
                                <a href="/perpanjang-sewa/{{ $booking->id }}" class="btn btn-pay">
                                    <i class="fas fa-calendar-plus"></i> Perpanjang
                                </a>
                                <a href="/submitKeluhan" class="btn btn-cancel">
                                    <i class="fas fa-exclamation-triangle"></i> Lapor
                                </a>
                                <form action="/booking/selesai/{{ $booking->id }}" method="POST" id="finishForm{{ $booking->id }}">
                                    @csrf
                                    <button type="button" class="btn" onclick="confirmSelesai({{ $booking->id }})" style="background-color: #6b7280; color: white;">
                                        <i class="fas fa-flag-checkered"></i> Selesaikan
                                    </button>
                                </form>
                            @else
                                <a href="/pembayaran" class="btn btn-pay">
                                    <i class="fas fa-receipt"></i> Cek Pembayaran
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="icon-wrapper">
                        <i class="fas fa-bed"></i>
                    </div>
                    <h3>Belum ada sewa aktif</h3>
                    <p>Anda belum memiliki kos yang sedang disewa atau booking yang aktif.</p>
                    <a href="/daftarkos" class="btn btn-perpanjang" style="margin-top: 20px;">Cari Kos Sekarang</a>
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
            <a href="/menunggu-pembayaran" class="btn-card">Lihat Pembayaran</a>
            <i class="fas fa-file-invoice-dollar card-icon"></i>
        </article>
        
        <article class="info-card purple">
            <div>
                <h3>Bantuan</h3>
                <p>Butuh bantuan dengan booking?</p>
            </div>
            <a href="https://wa.me/628123456789" target="_blank" class="btn-card">Hubungi CS</a>
            <i class="fas fa-question-circle card-icon"></i>
        </article>
    </section>

    <!-- EXTEND LEASE MODAL -->
    <div class="modal-overlay" id="perpanjangModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Perpanjang Sewa</h3>
                <button class="close-btn" onclick="closePerpanjangModal()">&times;</button>
            </div>
            <div class="info-box">
                Anda akan memperpanjang sewa untuk <strong id="modalKosName">Kos</strong>.<br>
                Sewa Anda saat ini berakhir pada: <strong id="modalEndDate">DD/MM/YYYY</strong>
            </div>
            
            <form action="/perpanjang-sewa/store" method="POST" id="perpanjangForm"> <!-- Placeholder route -->
                @csrf
                <div class="form-group">
                    <label class="form-label" for="durasiSelect">Durasi Perpanjangan</label>
                    <select id="durasiSelect" name="durasi" class="form-control" onchange="calculateExtension()" required>
                        <option value="">Pilih durasi</option>
                        <option value="1">1 Bulan</option>
                        <option value="3">3 Bulan</option>
                        <option value="6">6 Bulan</option>
                        <option value="12">12 Bulan</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Tanggal Berakhir Baru</label>
                    <input type="text" id="newEndDate" class="form-control" readonly placeholder="DD/MM/YYYY">
                </div>
                
                <div class="total-section">
                    <span class="total-label">Total Biaya:</span>
                    <span class="total-amount" id="totalCost">Rp 0</span>
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" onclick="closePerpanjangModal()">Batal</button>
                    <button type="button" class="btn btn-submit" onclick="alert('Fitur perpanjang sewa segera hadir!')">Lanjut Bayar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('perpanjangModal');
            if (modal) document.body.appendChild(modal);

            // DRAG TO SCROLL FOR TABS (Desktop Only)
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
                    const walk = (x - startX) * 2; // scroll-fastness
                    tabNav.scrollLeft = scrollLeft - walk;
                });
            }
        });

        let currentPrice = 0;
        let currentEndDateStr = '';

        function openPerpanjangModal(kosName, endDate, monthlyPrice) {
            document.getElementById('modalKosName').textContent = kosName;
            document.getElementById('modalEndDate').textContent = endDate;
            document.getElementById('perpanjangModal').classList.add('show');
            
            currentPrice = monthlyPrice;
            currentEndDateStr = endDate; 
            
            document.getElementById('durasiSelect').value = '';
            document.getElementById('newEndDate').value = '';
            document.getElementById('totalCost').textContent = 'Rp 0';
        }

        function closePerpanjangModal() {
            document.getElementById('perpanjangModal').classList.remove('show');
        }

        function calculateExtension() {
            const duration = parseInt(document.getElementById('durasiSelect').value);
            if(!duration) {
                document.getElementById('newEndDate').value = '';
                document.getElementById('totalCost').textContent = 'Rp 0';
                return;
            }

            const total = duration * currentPrice;
            document.getElementById('totalCost').textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);

            const parts = currentEndDateStr.split('/');
            if (parts.length === 3) {
                const day = parseInt(parts[0]);
                const month = parseInt(parts[1]) - 1; 
                const year = parseInt(parts[2]);
                const date = new Date(year, month, day);
                date.setMonth(date.getMonth() + duration);
                
                const newDay = String(date.getDate()).padStart(2, '0');
                const newMonth = String(date.getMonth() + 1).padStart(2, '0');
                const newYear = date.getFullYear();
                
                document.getElementById('newEndDate').value = `${newDay}/${newMonth}/${newYear}`;
            }
        }
        
        function confirmSelesai(id) {
            Swal.fire({
                title: 'Selesaikan Penyewaan?',
                text: "Apakah Anda yakin ingin menyelesaikan penyewaan ini? Kamar akan menjadi tersedia kembali dan booking ini akan pindah ke riwayat.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Selesaikan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('finishForm' + id).submit();
                }
            });
        }
    </script>
@endsection
