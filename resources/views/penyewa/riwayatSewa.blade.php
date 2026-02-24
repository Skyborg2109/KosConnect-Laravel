@extends('penyewa.layout')

@section('title', 'Riwayat Sewa')

@section('active-sewaSaya', 'active')

@section('styles')
<style>
    /* == CSS HALAMAN SEWA SAYA == */
    .page-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    /* 1. KOTAK TAB */
    .sewa-container {
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
    
    /* Konten Tab */
    .tab-content {
        padding: 30px;
        min-height: 250px;
    }
    
    /* Untuk "empty state" jika diperlukan */
    .tab-content.empty-state {
        display: grid;
        place-items: center;
        color: #6c757d;
    }

    /* == KONTEN TAB: KARTU HORIZONTAL == */
    .sewa-details-card {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 24px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
    }
    
    .tab-content .sewa-details-card {
        margin-bottom: 20px;
    }
    .tab-content .sewa-details-card:last-child {
        margin-bottom: 0;
    }

    .sewa-info h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    
    .sewa-info .address,
    .sewa-info .date-info,
    .sewa-duration .date-info {
        font-size: 14px;
        color: #555;
        margin-bottom: 4px;
    }
    
    .sewa-duration {
        flex-shrink: 0;
        margin: 0 40px;
    }
    
    .sewa-actions {
        text-align: right;
        margin-left: auto;
    }
    
    .status-tag {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    /* Tag Hijau (Aktif/Lunas) */
    .status-tag.active {
        background-color: #d1fae5;
        color: #059669;
    }
    
    /* Tag Abu-abu (Selesai) */
    .status-tag.completed {
        background-color: #f1f3f5;
        color: #6c757d;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
</style>
@endsection

@section('content')
    <h1 class="page-title">Sewa Saya</h1>

    <section class="sewa-container">
        <nav class="tab-nav">
            <a class="tab-link" href="/sewaSaya">Sewa Aktif</a>
            <a class="tab-link active" href="/riwayat-sewa">Riwayat Sewa</a>
        </nav>
        
        <div class="tab-content">
            <div class="sewa-details-card">
                <div class="sewa-info">
                    <h4>Kos Mawar Residence</h4>
                    <p class="address">Jl. Mawar Rojo 1/A 8, Jakarta Selatan</p>
                    <p class="date-info"><strong>Selesai Pada:</strong> 1/11/2025</p>
                </div>
                <div class="sewa-duration">
                    <p class="date-info"><strong>Durasi:</strong> 6 bulan</p>
                    <p class="date-info"><strong>Mulai:</strong> 1/5/2025</p>
                </div>
                <div class="sewa-actions">
                    <span class="status-tag completed">Selesai</span>
                </div>
            </div>
            
            <div class="sewa-details-card">
                <div class="sewa-info">
                    <h4>Kos Flamboyan Residence</h4>
                    <p class="address">Jl. Flamboyan 2, Jakarta Pusat</p>
                    <p class="date-info"><strong>Selesai Pada:</strong> 1/10/2025</p>
                </div>
                <div class="sewa-duration">
                    <p class="date-info"><strong>Durasi:</strong> 1 tahun</p>
                    <p class="date-info"><strong>Mulai:</strong> 1/10/2024</p>
                </div>
                <div class="sewa-actions">
                    <span class="status-tag completed">Selesai</span>
                </div>
            </div>
        </div>
    </section>
@endsection