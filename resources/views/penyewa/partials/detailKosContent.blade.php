
<div class="modal-container">
    <div class="modal-header">
        <h3>{{ $kos->nama_kos }}</h3>
        <button type="button" class="close-btn" onclick="closeDetailModal()">&times;</button>
    </div>
    
    <div class="modal-body">
        <div class="card-image-wrapper">
            @if($kos->gambar)
                <img src="{{ $kos->gambar_url }}" alt="{{ $kos->nama_kos }}">
            @else
                <div class="no-image">
                    <i class="fas fa-home"></i>
                    <span>Foto Kos</span>
                </div>
            @endif
            
            <button class="wishlist-btn {{ $isWishlisted ? 'active' : '' }}" onclick="toggleWishlist({{ $kos->id }})">
                <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart"></i>
            </button>
        </div>
        
        <div class="info-grid">
            <div class="main-info">
                <span class="badge-jenis {{ $kos->jenis_kos }}" style="margin-bottom: 8px;">{{ ucfirst($kos->jenis_kos) }}</span>
                <h4 class="price-tag">Rp {{ number_format($kos->harga_dasar, 0, ',', '.') }} <span>/Bulan</span></h4>
                <div class="location">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $kos->alamat }}, {{ $kos->kota }}
                </div>
            </div>
            
            <div class="rating-info">
                <div class="stars">
                    @php
                        $avgRating = $kos->reviews->avg('rating') ?? 0;
                        $fullStars = floor($avgRating);
                        $halfStar = ($avgRating - $fullStars) >= 0.5;
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullStars)
                            <i class="fas fa-star filled"></i>
                        @elseif($i == $fullStars + 1 && $halfStar)
                            <i class="fas fa-star-half-alt filled"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <span class="rating-text">({{ number_format($avgRating, 1) }})</span>
            </div>
        </div>

        @if($isWishlisted)
        <div class="wishlist-alert">
            <i class="fas fa-heart"></i> Kos ini ada dalam Wishlist Anda
        </div>
        @endif
        
        <hr class="divider">

        <div class="detail-row">
            <div class="detail-item">
                <span class="label">Kamar Tersedia</span>
                <span class="value">{{ $kos->kamar->count() }} Kamar</span>
            </div>
            @if($kos->pemilik)
            <div class="detail-item">
                <span class="label">Pemilik</span>
                <span class="value">{{ $kos->pemilik->nama_user }}</span>
            </div>
            @endif
        </div>
        
        <div class="detail-section">
            <h4>Fasilitas</h4>
            <div class="facilities-list">
                @if(is_array($kos->fasilitas) && count($kos->fasilitas) > 0)
                    @foreach($kos->fasilitas as $fasilitas)
                        <span class="facility-badge">{{ $fasilitas }}</span>
                    @endforeach
                @elseif(is_string($kos->fasilitas) && !empty($kos->fasilitas))
                   @foreach(explode(',', $kos->fasilitas) as $fasilitas)
                        <span class="facility-badge">{{ trim($fasilitas) }}</span>
                   @endforeach
                @else
                    <span style="color: #94a3b8; font-style: italic;">Tidak ada fasilitas yang dicantumkan.</span>
                @endif
            </div>
        </div>

        <!-- NEW: Gallery Section -->
        @if($kos->images && $kos->images->count() > 0)
            @php
                $order = ['utama', 'bangunan', 'fasilitas', 'kamar', 'kamar_mandi', 'lainnya'];
                $groupedImages = $kos->images->groupBy('jenis_foto');
            @endphp
            <div class="detail-section">
                <h4>Galeri Foto</h4>
                <div class="gallery-container">
                    @foreach($order as $type)
                        @if(isset($groupedImages[$type]) && count($groupedImages[$type]) > 0)
                            <div class="gallery-group">
                                <h5 class="gallery-category-title">{{ ucwords(str_replace('_', ' ', $type)) }}</h5>
                                <div class="gallery-scroll">
                                    @foreach($groupedImages[$type] as $img)
                                        <div class="gallery-item" onclick="window.open('{{ $img->image_url }}', '_blank')">
                                            <img src="{{ $img->image_url }}" alt="{{ $type }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        
        <div class="detail-section">
            <h4>Deskripsi</h4>
            <p class="description-text">{{ $kos->deskripsi }}</p>
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn-action btn-contact" onclick="showContactModal('{{ $kos->pemilik->nama_user ?? 'Pemilik' }}', '{{ $kos->pemilik->nomor_telepon ?? '' }}')">
            <i class="fab fa-whatsapp"></i> Hubungi
        </button>
        
        @if($kos->kamar->count() > 0)
            <button type="button" class="btn-action btn-rent" onclick="openKonfirmasiFromDetail({{ $kos->id }})">
                Sewa Sekarang
            </button>
        @else
            <button class="btn-action btn-disabled" disabled>
                Kamar Penuh
            </button>
        @endif
    </div>
</div>

<style>
    /* Reset & Container */
    .modal-container {
        background-color: #fff;
        border-radius: 12px;
        width: 100%;
        max-width: 600px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        overflow: hidden;
        margin: auto;
        display: flex;
        flex-direction: column;
        max-height: 90vh; /* Ensure it fits in viewport */
    }

    /* Header */
    .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: #333;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        color: #999;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }
    
    .close-btn:hover { color: #333; }

    /* Body */
    .modal-body {
        padding: 20px;
        overflow-y: auto;
    }

    /* Image Section */
    .card-image-wrapper {
        position: relative;
        width: 100%;
        height: 220px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
        background-color: #f1f1f1;
    }

    .card-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #ccc;
    }

    .no-image i { font-size: 40px; margin-bottom: 5px; }

    .wishlist-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        transition: transform 0.2s;
    }

    .wishlist-btn:hover { transform: scale(1.1); }
    .wishlist-btn i { font-size: 18px; color: #ccc; }
    .wishlist-btn.active i { color: #dc3545; }

    /* Info Grid */
    .info-grid {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }

    .price-tag {
        font-size: 20px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 4px 0;
    }

    .price-tag span {
        font-size: 14px;
        font-weight: 400;
        color: #7f8c8d;
    }

    .location {
        font-size: 14px;
        color: #7f8c8d;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .rating-info {
        text-align: right;
    }

    .stars { color: #f1c40f; font-size: 14px; }
    .stars .filled { color: #f39c12; }
    .rating-text { font-size: 13px; color: #95a5a6; font-weight: 500; }

    /* Wishlist Alert */
    .wishlist-alert {
        background-color: #fff0f1;
        color: #e74c3c;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        border: 1px solid #fadbd8;
    }

    .divider { border: 0; border-top: 1px solid #eee; margin: 16px 0; }

    /* Details Rows */
    .detail-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-item .label {
        font-size: 12px;
        text-transform: uppercase;
        color: #95a5a6;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .detail-item .value {
        font-size: 15px;
        color: #2c3e50;
        font-weight: 600;
    }

    /* Sections */
    .detail-section { margin-bottom: 20px; }
    .detail-section h4 {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .facilities-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .facility-badge {
        background-color: #f7f9fa;
        color: #576574;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        border: 1px solid #ecf0f1;
    }

    .description-text {
        font-size: 14px;
        line-height: 1.6;
        color: #34495e;
        text-align: justify;
    }

    /* Gallery Styles */
    .gallery-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .gallery-group {
        margin-bottom: 5px;
    }
    
    .gallery-category-title {
        font-size: 14px;
        font-weight: 600;
        color: #7f8c8d;
        margin-bottom: 8px;
        text-transform: capitalize;
    }
    
    .gallery-scroll {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 8px;
        scroll-behavior: smooth;
    }
    
    .gallery-scroll::-webkit-scrollbar {
        height: 6px;
    }
    
    .gallery-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    .gallery-scroll::-webkit-scrollbar-thumb {
        background: #bdc3c7;
        border-radius: 3px;
    }
    
    .gallery-item {
        flex-shrink: 0;
        width: 120px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid #eee;
        transition: transform 0.2s;
    }
    
    .gallery-item:hover {
        transform: scale(1.05);
        border-color: #3498db;
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Footer Styles */
    .modal-footer {
        padding: 16px 20px;
        background-color: #fff;
        border-top: 1px solid #eee;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .btn-action {
        border: none;
        border-radius: 8px;
        padding: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-contact {
        background-color: #f8f9fa;
        color: #2c3e50;
        border: 1px solid #dfe6e9;
    }
    
    .btn-contact:hover { background-color: #e9ecef; }
    .btn-contact i { color: #25D366; font-size: 18px; }

    .btn-rent {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
    }
    
    .btn-rent:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(52, 152, 219, 0.4);
    }

    .btn-disabled {
        background-color: #ecf0f1;
        color: #95a5a6;
        cursor: not-allowed;
    }

    .badge-jenis {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 13px;
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
</style>
