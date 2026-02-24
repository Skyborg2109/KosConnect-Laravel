@extends('penyewa.layout')

@section('title', 'Tulis Review')

@section('active-review', 'active')

@section('styles')
<style>
    /* == CSS HALAMAN REVIEW == */
    .page-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #1e293b;
    }
    
    .review-container {
        background-color: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .tab-nav {
        display: flex;
        border-bottom: 1px solid #e9ecef;
        background-color: #f8fafc;
        padding: 0 20px;
    }
    
    .tab-nav a {
        padding: 16px 24px;
        font-size: 15px;
        font-weight: 500;
        color: #64748b;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        display: inline-block;
        transition: all 0.2s;
    }
    
    .tab-nav a:hover {
        color: #0f172a;
    }
    
    .tab-nav a.active {
        color: #2563eb;
        font-weight: 600;
        border-bottom-color: #2563eb;
    }
    
    .tab-content {
        padding: 30px;
    }
    
    /* == KONTEN TAB: FORM TULIS REVIEW == */
    .review-form .form-group {
        margin-bottom: 24px;
    }
    
    .review-form label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #334155;
    }
    
    .review-form input[type="text"],
    .review-form select,
    .review-form textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.2s;
    }

    .review-form input:focus,
    .review-form textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    .review-form textarea {
        min-height: 150px;
        resize: vertical;
    }

    /* Star Rating Interaction */
    .star-rating {
        display: flex;
        gap: 8px;
        font-size: 32px;
        color: #e2e8f0;
        cursor: pointer;
        width: fit-content;
    }
    
    .star-rating i {
        transition: color 0.2s;
    }
    
    .star-rating i.active,
    .star-rating i:hover,
    .star-rating i:hover ~ i {
        color: #f59e0b; /* Yellow */
    }
    
    /* Handle hover effect logic via CSS direction: rtl override trick or JS interaction */
    /* Since we will use JS for interaction, simple active class is enough */
    
    .btn-submit-review {
        width: 100%;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        padding: 14px;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
    }

    .btn-submit-review:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 10px -1px rgba(37, 99, 235, 0.3);
    }
</style>
@endsection

@section('content')
    <h1 class="page-title">Review & Rating Kos</h1>

    <section class="review-container">
        <nav class="tab-nav">
            <a class="tab-link" href="/review">Review Saya</a>
            <a class="tab-link active" href="#">Tulis Review</a>
        </nav>
        
        <div class="tab-content">
            
            <form class="review-form" action="/store-review" method="POST">
                @csrf
                <input type="hidden" name="kos_id" value="{{ $kos->id }}">
                
                <div class="form-group">
                    <label>Kos yang Direview</label>
                    <input type="text" value="{{ $kos->nama_kos }}" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                </div>
                
                <div class="form-group">
                    <label>Rating Keseluruhan</label>
                    <div class="star-rating" id="starRating">
                        <i class="far fa-star" data-value="1"></i>
                        <i class="far fa-star" data-value="2"></i>
                        <i class="far fa-star" data-value="3"></i>
                        <i class="far fa-star" data-value="4"></i>
                        <i class="far fa-star" data-value="5"></i>
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" required>
                </div>
                
                <!-- Commented out "Judul Review" as it's not in the controller validation, 
                     but kept existing input layout just in case, wrapped in "komentar" which IS in validation 
                     Wait, controller has 'rating' and 'komentar', but view had 'judul-review' and 'deskripsi-review'.
                     I will map deskripsi-review to komentar to match controller storeReview method.
                -->
                
                <div class="form-group">
                    <label for="komentar">Deskripsi Review</label>
                    <textarea id="komentar" name="komentar" placeholder="Ceritakan pengalaman Anda secara detail..." required></textarea>
                </div>
                
                <button type="submit" class="btn-submit-review">Kirim Review</button>
                
            </form>
            
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#starRating i');
        const ratingInput = document.getElementById('ratingInput');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;
                
                // Update visual
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.remove('far');
                        s.classList.add('fas');
                        s.style.color = '#f59e0b';
                    } else {
                        s.classList.remove('fas');
                        s.classList.add('far');
                        s.style.color = '#e2e8f0';
                    }
                });
            });
            
            // Hover effect
            star.addEventListener('mouseenter', function() {
                const value = this.getAttribute('data-value');
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                         s.style.color = '#f59e0b';
                    } else {
                         s.style.color = '#e2e8f0';
                    }
                });
            });
        });
        
        // Reset hover effect when leaving container, but keep selection
        document.getElementById('starRating').addEventListener('mouseleave', function() {
            const currentValue = ratingInput.value;
            stars.forEach(s => {
                if (currentValue && s.getAttribute('data-value') <= currentValue) {
                    s.classList.remove('far');
                    s.classList.add('fas');
                    s.style.color = '#f59e0b';
                } else {
                    s.classList.remove('fas');
                    s.classList.add('far');
                    s.style.color = '#e2e8f0';
                }
            });
        });
    });
</script>
@endsection