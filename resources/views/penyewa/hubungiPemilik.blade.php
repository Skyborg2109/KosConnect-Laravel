@extends('penyewa.layout')

@section('title', 'Hubungi Pemilik')

@section('active-daftarKos', 'active')

@section('styles')
<style>
        /* == CSS RESET & DASAR == */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        a.btn {
            text-decoration: none;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa; /* Latar belakang body abu-abu */
            color: #333;
            line-height: 1.6;
        }

        /* ===================================== */
        /* == CSS HANYA UNTUK MODAL HUBUNGI PEMILIK == */
        /* ===================================== */

        .contact-modal-container {
            background-color: #ffffff;
            border-radius: 8px;
            width: 100%;
            max-width: 450px; /* Lebar modal kontak, sedikit lebih kecil */
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden; /* Agar rapi */
            z-index: 1001;
        }
        
        .contact-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .contact-modal-header h3 {
            font-size: 20px;
            font-weight: 600;
        }
        
        .contact-modal-header .close-btn {
            font-size: 24px;
            color: #6c757d;
            background: none;
            border: none;
            cursor: pointer;
        }
        
        .contact-modal-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px; /* Jarak bawah antar form group */
        }

        .form-group label {
            display: block; /* Agar label di atas input */
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-family: inherit; /* Agar font sama dengan body */
            font-size: 14px;
            color: #333;
            min-height: 120px; /* Tinggi minimum textarea */
            resize: vertical; /* Hanya bisa resize vertikal */
            outline: none; /* Hilangkan outline default */
            transition: border-color 0.2s ease;
        }

        .form-group textarea:focus {
            border-color: #0d6efd; /* Border biru saat fokus */
        }

        .contact-modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #e9ecef;
            background-color: #f8f9fa;
            display: flex;
            justify-content: flex-end; /* Tombol di kanan */
            gap: 10px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .btn-batal {
            background-color: #e9ecef; /* Abu-abu terang */
            color: #495057;
        }

        .btn-batal:hover {
            background-color: #dee2e6;
            transform: translateY(-1px);
        }
        
        .btn-kirim {
            background-color: #0d6efd; /* Biru utama */
            color: #ffffff;
        }

        .btn-kirim:hover {
            background-color: #0b5ed7; /* Biru lebih gelap */
            transform: translateY(-1px);
        }
        
        .page-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
    </style>
@endsection

@section('content')
        
        <div class="container">
            <h1 class="page-title">Hubungi Pemilik</h1>
            
            <div class="contact-modal-container">
                <form method="POST" action="/kirimPesan">
                    <div class="contact-modal-header">
                        <h3>Hubungi Pemilik</h3>
                        <a href="/dashboard-Penyewa" class="close-btn" style="text-decoration:none;">&times;</a>
                    </div>
                    
                    <div class="contact-modal-body">
                        <div class="kos-info" style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                            <p style="font-size: 14px; color: #6c757d; margin-bottom: 4px;">Kos:</p>
                            <p style="font-weight: 600; color: #212529; font-size: 16px; margin-bottom: 4px;">{{ $kos->nama_kos }}</p>
                            <p style="font-size: 14px; color: #6c757d; margin-bottom: 8px;">{{ $kos->alamat }}</p>
                            @if($kos->pemilik)
                                <p style="font-size: 14px; color: #333; border-top: 1px solid #dee2e6; padding-top: 8px; margin-top: 8px;">
                                    Pemilik: <strong>{{ $kos->pemilik->nama_user }}</strong>
                                </p>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea id="message" name="message" placeholder="Tulis pesan Anda..." required></textarea>
                        </div>
                        
                    </div>
                    
                    <div class="contact-modal-footer">
                        <a href="/dashboard-penyewa" class="btn btn-batal">Batal</a>
                        <button type="submit" class="btn btn-kirim">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
        
@endsection