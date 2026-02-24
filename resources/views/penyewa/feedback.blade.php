@extends('penyewa.layout')

@section('title', 'Feedback')

@section('active-feedback', 'active')

@section('styles')
<style>
    /* == CSS HALAMAN FEEDBACK == */
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
    
    /* Tata Letak Berbasis Grid */
    .feedback-layout {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 24px;
        align-items: start;
    }
    
    @media (max-width: 992px) {
        .feedback-layout {
            grid-template-columns: 1fr;
        }
    }
    
    .feedback-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }
    
    .feedback-card h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    /* Form Styling */
    .feedback-form .form-group {
        margin-bottom: 20px;
    }
    
    .feedback-form label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }
    
    .feedback-form select,
    .feedback-form textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        background-color: #f8fafc;
        transition: all 0.2s ease;
    }

    .feedback-form select:focus,
    .feedback-form textarea:focus {
        outline: none;
        border-color: #2563eb;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    
    .btn-submit-feedback {
        width: 100%;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        padding: 14px;
        font-size: 15px;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-submit-feedback:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    /* History List */
    .history-item {
        background-color: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
        transition: all 0.2s ease;
    }

    .history-item:hover {
        border-color: #e2e8f0;
        background-color: #f8fafc;
    }
    
    .history-item h4 {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
    }
    
    .history-item p {
        font-size: 14px;
        color: #475569;
        margin-bottom: 12px;
        line-height: 1.5;
    }
    
    .status-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .feedback-card {
            padding: 24px;
        }
        .page-title {
            font-size: 20px;
        }
    }
</style>
@endsection

@section('content')
        
        <h1 class="page-title">Feedback Aplikasi</h1>

        @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="feedback-layout">
            
            <section class="feedback-card">
                <h3>Kirim Feedback</h3>
                <form class="feedback-form" method="POST" action="/feedback/submit">
                    @csrf
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="lapor_bug">Lapor Bug</option>
                            <option value="permintaan_fitur">Permintaan Fitur</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea id="pesan" name="pesan" placeholder="Tulis pesan Anda (minimal 10 karakter)..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn-submit-feedback">Kirim Feedback</button>
                </form>
            </section>
            
            <section class="feedback-card">
                <h3>Riwayat Feedback</h3>
                <div class="history-list">
                    @forelse($feedbackHistory as $feedback)
                    <article class="history-item" style="margin-bottom: 15px;">
                        <h4>{{ $feedback->judul }}</h4>
                        <p>{{ $feedback->deskripsi }}</p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <small>{{ $feedback->created_at->format('d/m/Y, H:i') }}</small>
                            <span class="status-badge" style="
                                @if($feedback->status == 'pending') background-color: #fef3c7; color: #92400e;
                                @elseif($feedback->status == 'diproses') background-color: #dbeafe; color: #1e40af;
                                @else background-color: #d1fae5; color: #065f46;
                                @endif">
                                {{ ucfirst($feedback->status) }}
                            </span>
                        </div>
                    </article>
                    @empty
                    <div style="text-align: center; padding: 40px 20px; color: #6c757d;">
                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                        <p>Belum ada riwayat feedback</p>
                        <small>Feedback yang Anda kirim akan muncul di sini</small>
                    </div>
                    @endforelse
                </div>
            </section>
            
        </div>

@endsection