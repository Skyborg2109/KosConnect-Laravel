<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kos Baru</title>
    
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
            padding: 40px 20px; /* Padding agar modal tidak nempel di layar */
        }

        /* ===================================== */
        /* == CSS MODAL TAMBAH DATA KOS == */
        /* ===================================== */

        .modal-container {
            background-color: #ffffff;
            border-radius: 8px;
            width: 100%;
            max-width: 600px; /* Modal ini lebih lebar */
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            z-index: 1001;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .modal-header h3 {
            font-size: 20px;
            font-weight: 600;
        }
        
        .modal-header .close-btn {
            font-size: 24px;
            color: #6c757d;
            background: none;
            border: none;
            cursor: pointer;
        }
        
        .modal-body {
            padding: 24px;
            max-height: 70vh; /* Agar bisa di-scroll */
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-family: inherit;
            font-size: 14px;
            color: #333;
            outline: none;
            transition: border-color 0.2s ease;
        }
        
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #0d6efd; /* Border biru saat fokus */
        }
        
        .form-group select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20width%3D%2220%22%20height%3D%2220%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M5%208l5%205%205-5z%22%20fill%3D%22%236c757d%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }
        
        /* Grid untuk Harga dan Jumlah Kamar */
        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        
        /* Grid untuk Fasilitas */
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 kolom */
            gap: 10px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 12px;
            border-radius: 4px;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
        }
        
        .checkbox-item input {
            margin-right: 8px;
            width: 16px;
            height: 16px;
        }
        
        .checkbox-item label {
            margin-bottom: 0; /* Override style label default */
            font-weight: 400;
            font-size: 14px;
        }

        .modal-footer {
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
        }

        .btn-batal {
            background-color: #e9ecef;
            color: #495057;
        }
        
        .btn-simpan {
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
        
        <div class="modal-header">
            <h3>Tambah Kos Baru</h3>
            <a href="/data-kos" class="close-btn" style="text-decoration:none;">&times;</a>
        </div>
        
        <form class="kos-form">
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="nama-kos">Nama Kos</label>
                    <input type="text" id="nama-kos" placeholder="Masukkan nama kos">
                </div>
                
                <div class="form-group">
                    <label for="pemilik-kos">Pemilik Kos</label>
                    <select id="pemilik-kos">
                        <option value="" disabled selected>Pilih Pemilik</option>
                        <option value="thobroni">Thobroni</option> 
                        <option value="biylork">BiyLork</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="alamat-kos">Alamat</label>
                    <textarea id="alamat-kos" placeholder="Masukkan alamat lengkap kos"></textarea>
                </div>
                
                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="harga-kos">Harga per Bulan (Rp)</label>
                        <input type="number" id="harga-kos" placeholder="cth: 800000">
                    </div>
                    <div class="form-group">
                        <label for="jumlah-kamar">Jumlah Kamar</label>
                        <input type="number" id="jumlah-kamar" placeholder="cth: 20">
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi-kos">Deskripsi</label>
                    <textarea id="deskripsi-kos" placeholder="Tulis deskripsi singkat kos"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Fasilitas</label>
                    <div class="checkbox-grid">
                        <div class="checkbox-item">
                            <input type="checkbox" id="fas-wifi">
                            <label for="fas-wifi">WiFi</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="fas-ac">
                            <label for="fas-ac">AC</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="fas-km-dalam">
                            <label for="fas-km-dalam">KM Dalam</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="fas-parkir">
                            <label for="fas-parkir">Parkir</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="fas-kasur">
                            <label for="fas-kasur">Kasur</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="fas-meja">
                            <label for="fas-meja">Meja</label>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <div class="modal-footer">
                <a href="/data-kos" class="btn btn-batal">Batal</a>
                <a href="/data-kos" class="btn btn-simpan">Simpan Kos Baru</a>
            </div>
        </form>
        
    </div>
    
</body>
</html>