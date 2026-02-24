<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* == CSS RESET & DASAR == */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa; /* Latar belakang body abu-abu */
            color: #333;
            line-height: 1.6;
            
            /* Trik untuk menengahkan modal di layar */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* ===================================== */
        /* == CSS MODAL PEMBAYARAN BERHASIL == */
        /* ===================================== */

        .modal-container {
            background-color: #ffffff;
            border-radius: 8px;
            width: 100%;
            max-width: 500px; /* Lebar modal */
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            z-index: 1001;
        }
        
        /* Bagian atas dengan ikon */
        .modal-header-icon {
            padding-top: 32px;
            padding-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        
        .icon-wrapper {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background-color: #d1fae5; /* Hijau muda */
            color: #059669; /* Hijau tua */
            font-size: 32px;
        }
        
        /* Konten tengah */
        .modal-body {
            padding: 0 32px;
            text-align: center;
        }
        
        .modal-body h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .modal-body p {
            font-size: 16px;
            color: #495057;
            margin-bottom: 24px;
        }
        
        /* Kotak biru "Langkah Selanjutnya" */
        .info-box {
            background-color: #f0f6ff; /* Biru sangat muda */
            border: 1px solid #dbeafe; /* Border biru muda */
            border-radius: 8px;
            padding: 16px;
            text-align: left;
            margin-bottom: 24px;
        }
        
        .info-box h4 {
            font-size: 16px;
            font-weight: 600;
            color: #0d6efd; /* Biru */
            margin-bottom: 12px;
        }
        
        .info-box ul {
            list-style-type: none; /* Hapus bullet default */
            padding-left: 0;
        }
        
        .info-box ul li {
            font-size: 14px;
            color: #333;
            position: relative;
            padding-left: 20px; /* Ruang untuk bullet kustom */
            margin-bottom: 8px;
        }
        
        /* Membuat bullet kustom */
        .info-box ul li::before {
            content: '•';
            color: #0d6efd; /* Bullet biru */
            font-size: 18px;
            font-weight: 700;
            position: absolute;
            left: 0;
            top: -3px;
        }

        /* Footer dengan tombol */
        .modal-footer {
            padding: 24px 32px;
            border-top: 1px solid #e9ecef;
            background-color: #f8f9fa;
            display: flex;
            justify-content: space-between; /* Tombol jadi rata */
            gap: 10px;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 48%; /* Bagi rata 2 tombol */
        }

        .btn-tutup {
            background-color: #e9ecef;
            color: #495057;
        }
        
        .btn-lihat-pembayaran {
            background-color: #0d6efd;
            color: #ffffff;
        }

        a.btn {
            text-decoration: none;
        }
        
    </style>
</head>
<body>

    <div class="modal-container">
        
        <div class="modal-header-icon">
            <div class="icon-wrapper">
                <i class="fas fa-check"></i>
            </div>
        </div>
        
        <div class="modal-body">
            
            <h3>Pembayaran Berhasil Dikirim!</h3>
            <p>Bukti pembayaran Anda sedang diverifikasi oleh tim kami. Anda akan mendapat notifikasi dalam 1x24 jam.</p>
            
            <div class="info-box">
                <h4>Langkah Selanjutnya:</h4>
                <ul>
                    <li>Tim akan memverifikasi pembayaran Anda</li>
                    <li>Booking akan dikonfirmasi setelah verifikasi</li>
                    <li>Anda akan mendapat email konfirmasi</li>
                    <li>Hubungi CS jika ada pertanyaan</li>
                </ul>
            </div>
            
        </div>
        
        <div class="modal-footer">
            <a href="/dashboard-penyewa" class="btn btn-tutup">Tutup</a>
            <a href="/pembayaran" class="btn btn-lihat-pembayaran">Lihat Pembayaran</a>
        </div>
        
    </div>
    
</body>
</html>