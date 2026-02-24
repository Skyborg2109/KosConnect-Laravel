@extends('penyewa.layout')

@section('title', 'Pembayaran')

@section('active-pembayaran', 'active')

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

        /* == CSS HALAMAN PEMBAYARAN == */

        .page-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        /* Kartu putih besar untuk tabel */
        .history-card {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
        }
        
        /* Header tabel kustom */
        .table-header {
            display: grid;
            grid-template-columns: 2fr 3fr 2fr 2fr 1.5fr;
            gap: 16px;
            padding: 16px 24px;
            border-bottom: 1px solid #e9ecef;
            background-color: #f8f9fa;
        }
        
        .table-header span {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
        }

        .table-row {
            display: grid; 
            grid-template-columns: 2fr 3fr 2fr 2fr 1.5fr; 
            gap: 16px; 
            padding: 16px 24px; 
            border-bottom: 1px solid #e9ecef; 
            align-items: center;
        }

        .table-row:last-child {
            border-bottom: none;
        }
        
        /* Badan tabel (tempat konten/pesan kosong) */
        .table-body {
            padding: 24px;
            min-height: 200px;
            display: grid;
            place-items: center;
        }
        
        .table-body .empty-state {
            font-size: 16px;
            color: #6c757d;
        }

        .status-badge {
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 11px; 
            font-weight: 600;
            display: inline-block;
        }

        .btn-detail {
            font-size: 13px; 
            color: #2563eb; 
            font-weight: 600;
        }

        /* == MOBILE RESPONSIVE == */
        @media (max-width: 768px) {
            .table-header {
                display: none; /* Sembunyikan header tabel di mobile */
            }

            .table-row {
                display: flex;
                flex-direction: column;
                gap: 12px;
                padding: 20px;
                border-bottom: 8px solid #f8f9fa; /* Spacer antar kartu */
                align-items: flex-start;
            }

            .table-row > span, 
            .table-row > a {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: flex-start; /* Aligns label to top */
                text-align: right; /* Aligns value text to right */
            }

            /* Tambahkan label untuk setiap kolom di mobile */
            .table-row > span:nth-child(1)::before { content: "Tanggal"; font-weight: 600; color: #64748b; font-size: 13px; text-align: left; Flex-shrink: 0; padding-right: 10px; }
            .table-row > span:nth-child(2)::before { content: "Kos"; font-weight: 600; color: #64748b; font-size: 13px; text-align: left; flex-shrink: 0; padding-right: 10px; }
            .table-row > span:nth-child(3)::before { content: "Jumlah"; font-weight: 600; color: #64748b; font-size: 13px; text-align: left; flex-shrink: 0; padding-right: 10px; }
            .table-row > span:nth-child(4)::before { content: "Status"; font-weight: 600; color: #64748b; font-size: 13px; text-align: left; flex-shrink: 0; padding-right: 10px; }
            
            /* Khusus tombol aksi */
            .table-row > a {
                background-color: #f1f5f9;
                padding: 10px;
                border-radius: 6px;
                justify-content: center;
                margin-top: 5px;
            }

            .page-title {
                font-size: 20px;
            }
        }
        
    </style>
@endsection

@section('content')
        
        <h1 class="page-title">Riwayat Pembayaran</h1>

        <section class="history-card">
            
            <div class="table-header">
                <span>Tanggal</span>
                <span>Kos</span>
                <span>Jumlah</span>
                <span>Status</span>
                <span>Aksi</span>
            </div>
            
            <div class="table-body-dynamic">
                @forelse($pembayarans as $p)
                <div class="table-row">
                    <span style="font-size: 14px;">{{ $p->tanggal_bayar->format('d M Y') }}</span>
                    <span style="font-size: 14px; font-weight: 500;">{{ $p->booking->kamar->kos->nama_kos ?? 'Kos' }}</span>
                    <span style="font-size: 14px;">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</span>
                    <span>
                        <span class="status-badge" style="
                            @if($p->status == 'pending') background: #fef3c7; color: #92400e; 
                            @elseif($p->status == 'verified') background: #dcfce7; color: #166534; 
                            @else background: #fee2e2; color: #991b1b; @endif">
                            {{ strtoupper($p->status) }}
                        </span>
                    </span>
                    <a href="{{ $p->bukti_transfer_url }}" target="_blank" class="btn-detail">Lihat Bukti</a>
                </div>
                @empty
                <div class="empty-state" style="padding: 48px; text-align: center;">
                    <p class="empty-state" style="color: #64748b;">Belum ada riwayat pembayaran</p>
                </div>
                @endforelse
            </div>
            
        </section>

@endsection