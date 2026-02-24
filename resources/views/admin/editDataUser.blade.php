<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - KosConnect</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
        /* == CSS MODAL EDIT PENGGUNA == */
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
        
        /* Catatan kecil untuk password */
        .form-group .note {
            font-size: 12px;
            color: #6c757d;
            font-style: italic;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="tel"],
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

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
        }
        
    </style>
</head>
<body>

    <div class="modal-container">
        
        <div class="modal-header">
            <h3>Edit Pengguna</h3>
            <a href="/data-pengguna" class="close-btn" style="text-decoration:none;">&times;</a>
        </div>
        
        <form action="/update-user/{{ $user->id }}" method="POST" class="user-form">
            @csrf
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="nama-lengkap">Nama Lengkap</label>
                    <input type="text" id="nama-lengkap" name="nama_user" value="{{ old('nama_user', $user->nama_user) }}" required>
                    @error('nama_user')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="tel" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon', $user->nomor_telepon) }}">
                    @error('nomor_telepon')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" required>
                        <option value="penyewa" {{ old('role', $user->role) == 'penyewa' ? 'selected' : '' }}>Penyewa</option>
                        <option value="pemilik" {{ old('role', $user->role) == 'pemilik' ? 'selected' : '' }}>Pemilik</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" placeholder="••••••••">
                    <span class="note">Kosongkan jika tidak ingin mengubah password</span>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
            
            <div class="modal-footer">
                <a href="/data-pengguna" class="btn btn-batal">Batal</a>
                <button type="submit" class="btn btn-simpan">Simpan Perubahan</button>
            </div>
        </form>
        
    </div>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#0d6efd'
        }).then(() => {
            window.location.href = '/data-pengguna';
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc3545'
        });
    </script>
    @endif
    
</body>
</html>