<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - KosConnect</title>
    
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
        /* == CSS MODAL TAMBAH PENGGUNA == */
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
        }

        .form-group {
            margin-bottom: 16px; /* Jarak antar form group */
        }

        .form-group label {
            display: block; /* Agar label di atas input */
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group select {
            width: 100%;
            padding: 10px 12px; /* Padding lebih ramping untuk admin */
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-family: inherit;
            font-size: 14px;
            color: #333;
            outline: none;
            transition: border-color 0.2s ease;
        }
        
        .form-group input:focus,
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
            background-color: #e9ecef; /* Abu-abu terang */
            color: #495057;
        }
        
        .btn-simpan {
            background-color: #0d6efd; /* Biru utama */
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
            <h3>Tambah Pengguna</h3>
            <a href="/data-pengguna" class="close-btn" style="text-decoration:none;">&times;</a>
        </div>
        
        <form class="user-form">
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="nama-lengkap">Nama Lengkap</label>
                    <input type="text" id="nama-lengkap" placeholder="Masukkan nama lengkap">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Masukkan email">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="Masukkan password">
                </div>

                <div class="form-group">
                    <label for="konfirmasi-password">Konfirmasi Password</label>
                    <input type="password" id="konfirmasi-password" placeholder="Konfirmasi password">
                </div>
                
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role">
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="penyewa">Penyewa</option>
                        <option value="pemilik">Pemilik</option>
                    </select>
                </div>
                
            </div>
            
            <div class="modal-footer">
                <a href="/data-pengguna" class="btn btn-batal">Batal</a>
                <a href="/data-pengguna" class="btn btn-simpan">Simpan Pengguna</a>
            </div>
        </form>
        
    </div>
    
</body>
</html>