@extends('penyewa.layout')

@section('title', 'Daftar Kos')

@section('active-daftarKos', 'active')

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



        /* == CSS HALAMAN DAFTAR KOS == */

        .page-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        /* == 2. FILTER PENCARIAN (Dipakai ulang dari Dashboard) == */
        .filter-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: 1px solid #e9ecef;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .search-bar-container {
            display: flex;
            gap: 20px;
            width: 100%;
            margin-bottom: 24px;
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
            border-top: 1px solid #e2e8f0;
            padding-top: 24px;
        }

        .quick-filter-label {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
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
        
        /* == 3. GRID KARTU KOS (Dipakai ulang dari Dashboard) == */
        .kos-grid {
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

        .card-image-placeholder {
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

        .card-image-placeholder::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.1) 0%, transparent 70%);
            animation: imageShimmer 3s ease-in-out infinite;
        }

        @keyframes imageShimmer {
            0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
            50% { transform: translate(-50%, -50%) rotate(180deg); }
        }

        .card-image-placeholder .fa-home {
            font-size: 48px;
            margin-bottom: 12px;
            color: #0d6efd;
            filter: drop-shadow(0 2px 4px rgba(13, 110, 253, 0.3));
        }

        .card-image-placeholder span {
            font-size: 16px;
            font-weight: 500;
            z-index: 1;
            position: relative;
        }
        
        .card-content {
            padding: 20px;
        }

        .card-content h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1e293b;
            line-height: 1.3;
        }

        .card-content .rating {
            font-size: 14px;
            color: #f59e0b;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-content .rating span {
            color: #64748b;
            font-weight: 500;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .card-content .address {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .card-content .address i {
            color: #94a3b8;
            margin-top: 2px;
        }

        .card-content .price {
            font-size: 18px;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 16px;
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .card-content .price small {
            font-weight: 400;
            color: #64748b;
            font-size: 14px;
        }

        .card-content .facilities {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .card-content .facilities span {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            color: #475569;
            font-weight: 500;
            border: 1px solid #cbd5e1;
            transition: all 0.2s ease;
        }

        .card-content .facilities span:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: scale(1.05);
        }

        .card-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .action-row {
            display: flex;
            gap: 12px;
            width: 100%;
        }

        .card-buttons .btn {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
        }
        
        .action-row .btn {
            flex: 1;
        }

        .card-buttons .btn-detail {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
        }

        .card-buttons .btn-detail:hover {
            background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(13, 110, 253, 0.4);
        }

        .card-buttons .btn-contact {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(25, 135, 84, 0.3);
        }

        .card-buttons .btn-contact:hover {
            background: linear-gradient(135deg, #146c43 0%, #0f5132 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(25, 135, 84, 0.4);
        }

        .card-buttons .btn-sewa {
            width: 100%;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
        }

         .card-buttons .btn-sewa:hover {
            background: linear-gradient(135deg, #0a58ca 0%, #084298 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(13, 110, 253, 0.4);
        }
        
        /* == 4. CSS BARU: PAGINATION (Navigasi Halaman) == */
        .pagination {
            display: flex;
            justify-content: center;
            margin: 30px 0 20px 0;
        }
        
        .pagination ul {
            list-style: none;
            display: flex;
            gap: 8px;
            padding: 0;
        }
        
        .pagination ul li a {
            padding: 8px 16px;
            border: 1px solid #dee2e6;
            background-color: #ffffff;
            border-radius: 4px;
            color: #0d6efd;
            font-weight: 600;
            font-size: 14px;
        }
        
        .pagination ul li a:hover {
            background-color: #f1f3f5;
        }
        
        .pagination ul li a.active {
            background-color: #0d6efd;
            color: #ffffff;
            border-color: #0d6efd;
        }
        
        .pagination ul li a.disabled {
            color: #adb5bd;
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        /* == MOBILE RESPONSIVE == */
        @media (max-width: 768px) {
            .filter-section {
                padding: 20px;
            }

            .search-bar-container {
                flex-direction: column;
                gap: 15px;
            }

            .search-input-wrapper input {
                padding-right: 20px;
            }

            .search-bar-container select {
                width: 100%;
            }

            .btn-search {
                width: 100%;
                justify-content: center;
            }

            .quick-filter-container {
                flex-wrap: nowrap;
                overflow-x: auto;
                justify-content: flex-start;
                padding-bottom: 8px;
                scrollbar-width: none;
            }
            
            .quick-filter-container::-webkit-scrollbar {
                display: none;
            }
            
            .quick-filter-label {
                white-space: nowrap;
            }
            
            .filter-tag {
                white-space: nowrap;
                flex-shrink: 0;
            }
            
            .kos-grid {
                grid-template-columns: 1fr;
            }

            .action-row {
                flex-direction: column;
            }
        }
    </style>
@endsection

@section('content')
        
        <h1 class="page-title">Temukan Kos Impian Anda</h1>
        
        <section class="filter-section">
            <form method="GET" action="/daftarkos">
                <div class="search-bar-container">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kos berdasarkan nama, lokasi, atau fasilitas..">
                    </div>
                    <select name="harga" id="harga">
                        <option value="semua">Semua Harga</option>
                        <option value="murah">Rp 0 - Rp 1.000.000</option>
                        <option value="menengah">Rp 1.000.000 - Rp 2.000.000</option>
                    </select>
                    <button type="submit" class="btn btn-search">
                        <i class="fas fa-search"></i> Cari Kos
                    </button>
                </div>
                <input type="hidden" name="fasilitas" id="fasilitas-input" value="{{ request('fasilitas') }}">
            </form>
            
            <div class="quick-filter-container">
                <span class="quick-filter-label">Filter Cepat:</span>
                @php
                    $currentFasilitas = explode(',', request('fasilitas', ''));
                @endphp
                <button class="filter-tag {{ in_array('wifi', $currentFasilitas) ? 'active' : '' }}" data-filter="wifi">
                    <i class="fas fa-wifi"></i> WiFi
                </button>
                <button class="filter-tag {{ in_array('ac', $currentFasilitas) ? 'active' : '' }}" data-filter="ac">
                    <i class="fas fa-snowflake"></i> AC
                </button>
                <button class="filter-tag {{ in_array('kamar_mandi_dalam', $currentFasilitas) ? 'active' : '' }}" data-filter="kamar_mandi_dalam">
                    <i class="fas fa-bed"></i> Kamar Mandi Dalam
                </button>
                <button class="filter-tag {{ in_array('parkir', $currentFasilitas) ? 'active' : '' }}" data-filter="parkir">
                    <i class="fas fa-car"></i> Parkir
                </button>
            </div>
        </section>

        <section class="kos-grid">
            @forelse($kos as $k)
            <article class="kos-card">
                <div class="card-header">
                    @php
                        $isWishlisted = in_array($k->id, $wishlistKosIds ?? []);
                    @endphp
                    <i class="{{ $isWishlisted ? 'fas' : 'far' }} fa-heart {{ $isWishlisted ? 'active' : 'inactive' }} wishlist-icon" 
                       data-kos-id="{{ $k->id }}" 
                       onclick="toggleWishlist({{ $k->id }})"></i>
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
                            $avgRating = $k->reviews_avg_rating ?? $k->reviews->avg('rating') ?? 0;
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
                            <span style="background: none; border: none; color: #94a3b8; font-size: 12px; font-style: italic;">Tidak ada fasilitas</span>
                        @endif
                    </div>
                    <div class="card-buttons">
                        <div class="action-row">
                            <a href="{{ url('/detailKos/' . $k->id) }}" class="btn btn-detail">Lihat Detail</a>
                            <a href="{{ url('/hubungiPemilik/' . $k->id) }}" class="btn btn-contact">Hubungi</a>
                        </div>
                        <a href="{{ url('/tampilKonfirmasiSewa/' . $k->id) }}" class="btn btn-sewa">Sewa Sekarang</a>
                    </div>
                </div>
            </article>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                <p>Tidak ada kos yang ditemukan.</p>
            </div>
            @endforelse
        </section>
        
        
        @if($kos->hasPages())
        <div class="pagination-wrapper" style="margin-top: 30px;">
             {{ $kos->withQueryString()->links() }}
        </div>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const filterTags = document.querySelectorAll('.filter-tag');
                const fasilitasInput = document.getElementById('fasilitas-input');
                const filterForm = document.querySelector('.filter-section form');
                
                filterTags.forEach(tag => {
                    tag.addEventListener('click', function() {
                        this.classList.toggle('active');
                        
                        // Update hidden input
                        const activeFilters = Array.from(document.querySelectorAll('.filter-tag.active'))
                            .map(t => t.dataset.filter);
                        fasilitasInput.value = activeFilters.join(',');
                        
                        // Submit form automatically
                        filterForm.submit();
                    });
                });
            });
        </script>

@endsection