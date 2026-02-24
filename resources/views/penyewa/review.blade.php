@extends('penyewa.layout')

@section('title', 'Review & Rating Kos')

@section('active-review', 'active')

@section('styles')
<style>
    /* == CSS HALAMAN REVIEW == */
    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title::before {
        content: '';
        width: 4px;
        height: 24px;
        background: #2563eb;
        border-radius: 2px;
    }
    
    .review-container {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }
    
    .tab-nav {
        display: flex;
        flex-wrap: nowrap;
        border-bottom: 1px solid #e5e7eb;
        background-color: #f9fafb;
        overflow-x: auto;
        overflow-y: hidden;
        scrollbar-width: none;
        -ms-overflow-style: none;
        -webkit-overflow-scrolling: touch;
        cursor: grab;
        user-select: none;
        width: 100%;
        padding: 0 10px;
    }

    .tab-nav::-webkit-scrollbar {
        display: none;
    }
    
    .tab-nav:active {
        cursor: grabbing;
    }
    
    .tab-nav a {
        padding: 16px 24px;
        font-size: 15px;
        font-weight: 600;
        color: #64748b;
        border-bottom: 3px solid transparent;
        margin-bottom: -1px;
        white-space: nowrap;
        text-decoration: none;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    
    .tab-nav a:hover {
        color: #1e293b;
    }
    
    .tab-nav a.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
        background-color: transparent;
    }
    
    .tab-content {
        padding: 32px;
        min-height: 400px;
        background-color: #fff;
    }
    
    .btn {
        padding: 10px 24px;
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

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .btn:active {
        transform: translateY(0);
    }

    .review-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    .review-card:hover {
        border-color: #2563eb;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        transform: scale(1.005);
    }

    .star-rating {
        display: flex;
        gap: 4px;
        font-size: 16px;
        color: #fbbf24;
    }

    .review-history-card {
        padding: 24px;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s;
    }

    .review-history-card:last-child {
        border-bottom: none;
    }

    .review-history-card:hover {
        background-color: #f8fafc;
    }

    .comment-box {
        font-size: 15px;
        color: #334155;
        line-height: 1.6;
        background-color: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-top: 12px;
    }

    @media (max-width: 768px) {
        .tab-content {
            padding: 20px 16px;
        }
        .review-card {
            flex-direction: column;
            text-align: center;
            gap: 20px;
            padding: 20px;
        }
        .review-card .btn {
            width: 100%;
        }
        .page-title {
            font-size: 20px;
        }
    }
</style>
@endsection

@section('content')
    <h1 class="page-title">Review & Rating Kos</h1>

    <section class="review-container">
        <nav class="tab-nav">
            <a class="tab-link {{ !request('tab') ? 'active' : '' }}" href="/review">Review Saya</a>
            <a class="tab-link {{ request('tab') == 'tulis' ? 'active' : '' }}" href="/review?tab=tulis">Tulis Review</a>
        </nav>
        
        <div class="tab-content">
            @if(request('tab') == 'tulis')
                {{-- TAB: TULIS REVIEW (DAFTAR KOS YANG BISA DIREVIEW) --}}
                @if(isset($kosToReview) && $kosToReview->count() > 0)
                    <div style="display: grid; gap: 16px;">
                        @foreach($kosToReview as $kos)
                            <div class="review-card">
                                <div>
                                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 6px; color: #0f172a;">{{ $kos->nama_kos }}</h3>
                                    <p style="font-size: 14px; color: #64748b; display: flex; align-items: center; gap: 6px;">
                                        <i class="fas fa-map-marker-alt" style="color: #94a3b8;"></i> 
                                        {{ $kos->alamat }}
                                    </p>
                                </div>
                                <a href="/tulis-review/{{ $kos->id }}" class="btn" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #fff;">
                                    <i class="fas fa-pen-nib"></i> Tulis Review
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; color: #64748b; padding: 60px 20px;">
                        <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                            <i class="fas fa-home" style="font-size: 32px; color: #94a3b8;"></i>
                        </div>
                        <h4 style="color: #1e293b; margin-bottom: 8px; font-weight: 600;">Tidak Ada Kos untuk Direview</h4>
                        <p style="font-size: 14px; max-width: 300px; margin: 0 auto;">Review hanya dapat diberikan setelah Anda memiliki riwayat sewa di kos tersebut.</p>
                    </div>
                @endif
            @else
                {{-- TAB: REVIEW SAYA (RIWAYAT) --}}
                @if($reviews->count() > 0)
                    <div style="display: flex; flex-direction: column;">
                        @foreach($reviews as $review)
                            <div class="review-history-card">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 12px; align-items: flex-start;">
                                    <div>
                                        <h3 style="font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">{{ $review->kos->nama_kos }}</h3>
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span style="font-size: 13px; color: #94a3b8; background: #f8fafc; padding: 2px 8px; border-radius: 4px; border: 1px solid #f1f5f9;">
                                                <i class="far fa-calendar-alt"></i> {{ $review->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="comment-box">
                                    {{ $review->komentar ?? $review->ulasan ?? 'Tidak ada komentar tertulis.' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; color: #64748b; padding: 60px 20px;">
                        <div style="width: 80px; height: 80px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
                            <i class="fas fa-comment-slash" style="font-size: 32px; color: #94a3b8;"></i>
                        </div>
                        <h4 style="color: #1e293b; margin-bottom: 8px; font-weight: 600;">Belum Ada Review</h4>
                        <p style="font-size: 14px; max-width: 300px; margin: 0 auto;">Review yang Anda berikan untuk kos-kosan akan tampil di sini.</p>
                    </div>
                @endif
            @endif
        </div>
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
    </script>
@endsection
