@extends('penyewa.layout')

@section('title', 'Wishlist Saya')

@section('active-wishlist', 'active')

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
        max-width: 1100px;
        margin: 20px auto;
        padding: 0 20px;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    .btn {
        width: 100%;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        transition: all 0.2s ease;
    }

    .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn:active {
        transform: scale(0.95);
    }

    /* == 4. REKOMENDASI / WISHLIST KOS == */
    .recommendations .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding: 20px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .recommendations .section-header h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .recommendations .section-header h3 i {
        color: #dc3545;
        font-size: 28px;
    }

    /* TOMBOL HAPUS SEMUA BARU */
    .btn-clear-all {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: #ffffff;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-clear-all:hover {
        background: linear-gradient(135deg, #c82333 0%, #a02622 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    }

    .btn-clear-all:active {
        transform: translateY(0);
    }

    .empty-wishlist {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin: 40px 0;
    }

    .empty-wishlist i {
        font-size: 80px;
        color: #cbd5e1;
        margin-bottom: 20px;
        display: block;
    }

    .empty-wishlist h3 {
        font-size: 24px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 12px;
    }

    .empty-wishlist p {
        color: #64748b;
        font-size: 16px;
        margin-bottom: 24px;
    }

    .empty-wishlist .btn {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        padding: 14px 28px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .empty-wishlist .btn:hover {
        background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
    }

    .kos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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
        animation: cardFadeIn 0.6s ease-out both;
    }

    .kos-card:nth-child(1) { animation-delay: 0.1s; }
    .kos-card:nth-child(2) { animation-delay: 0.2s; }
    .kos-card:nth-child(3) { animation-delay: 0.3s; }
    .kos-card:nth-child(4) { animation-delay: 0.4s; }
    .kos-card:nth-child(5) { animation-delay: 0.5s; }
    .kos-card:nth-child(6) { animation-delay: 0.6s; }

    @keyframes cardFadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
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

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .kos-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }

    .kos-card .card-header {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 22px;
    }

    .kos-card .card-header .fa-heart.active {
        color: #dc3545;
        animation: heartbeat 1.5s infinite;
    }

    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .kos-card .card-header .fa-heart.inactive {
        color: #adb5bd;
    }

    .card-image-placeholder {
        height: 180px;
        background-color: #e9ecef;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #adb5bd;
    }

    .card-image-placeholder .fa-home { font-size: 40px; margin-bottom: 8px; }
    .card-content { padding: 16px; }
    .card-content h4 { font-size: 18px; font-weight: 600; margin-bottom: 4px; }
    .card-content .rating { font-size: 14px; color: #f59e0b; margin-bottom: 8px; }
    .card-content .rating span { color: #6c757d; margin-left: 4px; }
    .card-content .address { font-size: 14px; color: #495057; margin-bottom: 8px; }
    .card-content .price { font-size: 16px; font-weight: 700; color: #212529; margin-bottom: 12px; }
    .card-content .price small { font-weight: 400; color: #6c757d; }
    .card-content .facilities { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }
    .card-content .facilities span { background-color: #f1f3f5; padding: 4px 10px; border-radius: 12px; font-size: 12px; color: #495057; }


    /* == MODIFIKASI KUNCI PADA BAGIAN TOMBOL KARTU == */
    .card-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .card-buttons .action-row {
        display: flex;
        gap: 12px;
        width: 100%;
    }

    .card-buttons .btn-detail {
        background: linear-gradient(135deg, #343a40 0%, #212529 100%);
        color: #ffffff;
        flex: 1;
    }

    .card-buttons .btn-contact {
        background: linear-gradient(135deg, #198754 0%, #146c43 100%);
        color: #ffffff;
        flex: 1;
    }

    .card-buttons .btn-rent {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: #ffffff;
        width: 100%;
    }

    @media (max-width: 768px) {
        .card-buttons .action-row {
            flex-direction: column;
        }
        .kos-grid {
            grid-template-columns: 1fr;
        }
    }

</style>
@endsection

@section('content')

<section class="recommendations">
    <div class="section-header">
        <h3><i class="fas fa-heart"></i>Wishlist Saya</h3>
        <button class="btn-clear-all">
            <i class="fas fa-trash-alt"></i>
            Hapus Semua
        </button>
    </div>

    <!-- Empty State -->
    <div class="empty-wishlist" id="emptyWishlist" style="display: {{ count($wishlists) > 0 ? 'none' : 'block' }};">
        <i class="fas fa-heart-broken"></i>
        <h3>Wishlist Kosong</h3>
        <p>Anda belum menambahkan kos apapun ke wishlist. Mulai jelajahi kos impian Anda!</p>
    </div>

    <div class="kos-grid" id="wishlistGrid">
        @forelse($wishlists as $wishlist)
            @php $k = $wishlist->kos; @endphp
            @if($k)
            <article class="kos-card">
                <div class="card-header">
                    <i class="fas fa-heart active" onclick="toggleWishlist({{ $k->id }})"></i>
                </div>
                <div class="card-image-placeholder">
                   @if($k->gambar)
                        <img src="{{ $k->gambar_url }}" alt="{{ $k->nama_kos }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-home"></i>
                        <span>Foto Kos</span>
                    @endif
                </div>
                <div class="card-content">
                    <h4>{{ $k->nama_kos }}</h4>
                    <div class="rating">
                         @php
                            $avgRating = $k->reviews->avg('rating') ?? 0;
                        @endphp
                        <i class="fas fa-star"></i>
                        <span>({{ number_format($avgRating, 1) }})</span>
                    </div>
                    <p class="address">{{ $k->alamat }}, {{ $k->kota }}</p>
                    <p class="price">Rp {{ number_format($k->harga_dasar, 0, ',', '.') }} <small>/Bulan</small></p>
                    <div class="facilities">
                        @if(is_array($k->fasilitas) && count($k->fasilitas) > 0)
                            @foreach(array_slice($k->fasilitas, 0, 3) as $fas)
                                <span>{{ $fas }}</span>
                            @endforeach
                        @elseif(is_string($k->fasilitas) && !empty($k->fasilitas))
                            @foreach(array_slice(explode(',', $k->fasilitas), 0, 3) as $fas)
                                <span>{{ trim($fas) }}</span>
                            @endforeach
                        @else
                            <span style="background: none; border: none; color: #94a3b8; font-size: 11px; font-style: italic;">Tidak ada fasilitas</span>
                        @endif
                    </div>
                    <div class="card-buttons">
                        <div class="action-row">
                            <a href="{{ url('/detailKos/' . $k->id) }}" class="btn btn-detail">Lihat Detail</a>
                            <button class="btn btn-contact" onclick="showContactModal('{{ $k->pemilik->nama_user ?? 'Pemilik' }}', '{{ $k->pemilik->nomor_telepon ?? '' }}')">Hubungi</button>
                        </div>
                        <button class="btn btn-rent" onclick="openKonfirmasiDirect({{ $k->id }})">Sewa Sekarang</button>
                    </div>
                </div>
            </article>
            @endif
        @empty
             {{-- Empty state is handled by the #emptyWishlist div above --}}
        @endforelse
    </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnClearAll = document.querySelector('.btn-clear-all');
        const emptyState = document.getElementById('emptyWishlist');
        const wishlistGrid = document.getElementById('wishlistGrid');

        if (btnClearAll) {
            btnClearAll.addEventListener('click', function() {
                Swal.fire({
                    title: 'Hapus Semua Wishlist?',
                    text: "Anda yakin ingin menghapus semua item dari wishlist?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus Semua!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send DELETE request
                        fetch('/wishlist/remove-all', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Terhapus!',
                                    data.message,
                                    'success'
                                );
                                
                                // Update UI
                                if (wishlistGrid) wishlistGrid.style.display = 'none';
                                if (emptyState) emptyState.style.display = 'block';
                                btnClearAll.style.display = 'none'; // Hide the button itself
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Gagal menghapus wishlist.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan sistem.',
                                'error'
                            );
                        });
                    }
                });
            });
        }
    });
</script>
@endsection