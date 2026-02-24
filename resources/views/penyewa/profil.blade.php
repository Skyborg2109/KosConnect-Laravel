@extends('penyewa.layout')

@section('title', 'Profil')

@section('active-profil', 'active')

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




        /* == CSS HALAMAN PROFIL == */
        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 30px;
            text-align: center;
        }
        
        /* Tata Letak */
        .settings-layout {
            max-width: 800px;
            margin: 0 auto;
        }
        
        /* Kartu putih */
        .settings-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Profile Photo Section */
        .profile-photo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid #f1f5f9;
        }

        .profile-photo-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #f8fafc;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 15px;
            background-color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .profile-photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-photo-preview i {
            font-size: 48px;
            color: #cbd5e1;
        }

        .btn-upload-photo {
            background-color: #f1f5f9;
            color: #475569;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-upload-photo:hover {
            background-color: #e2e8f0;
            color: #1e293b;
        }
        
        .settings-card h3 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 24px;
        }
        
        /* Style Form Umum */
        .profile-form .form-group {
            margin-bottom: 24px;
        }
        
        .profile-form label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 8px;
        }
        
        .profile-form input[type="text"],
        .profile-form input[type="email"],
        .profile-form input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            color: #1e293b;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        .profile-form input:focus {
            outline: none;
            border-color: #0d6efd;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
        
        /* Tombol Submit */
        .btn-submit {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-submit.blue {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }
        
        /* Password Toggle Icon */
        .password-wrapper {
            position: relative;
        }
        
        .password-wrapper input {
            padding-right: 48px;
        }
        
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            font-size: 18px;
            transition: color 0.2s;
        }
        
        .toggle-password:hover {
            color: #475569;
        }
        
        @media (max-width: 768px) {
            .settings-card {
                padding: 24px 20px;
            }
            .page-title {
                font-size: 20px;
            }
        }
    </style>
@endsection

@section('content')
        
        <h1 class="page-title">Pengaturan Profil</h1>

        <div class="settings-layout">
            
            <section class="settings-card">
                <!-- Profile Photo Section -->
                <div class="profile-photo-container">
                    <div class="profile-photo-preview">
                        @if($user->foto_profil)
                            <img src="{{ $user->foto_profil }}" alt="Profil" id="profile-preview-img">
                        @elseif($user->avatar)
                            <img src="{{ $user->avatar }}" alt="Profil" id="profile-preview-img">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                    <form id="profile-photo-form" action="/update-profil-penyewa-photo" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="photo-input" name="photo" style="display: none;" accept="image/*" onchange="submitPhoto()">
                        <button type="button" class="btn-upload-photo" onclick="document.getElementById('photo-input').click()">
                            <i class="fas fa-camera"></i> Ubah Foto Profil
                        </button>
                    </form>
                </div>

                <h3>Informasi Profil</h3>
                
                @if(session('success'))
                    <div style="background-color: #d1fae5; color: #059669; padding: 12px; border-radius: 4px; margin-bottom: 24px; font-size: 14px; font-weight: 500;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div style="background-color: #fee2e2; color: #dc2626; padding: 12px; border-radius: 4px; margin-bottom: 24px; font-size: 14px; font-weight: 500;">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif
                
                <form class="profile-form" action="/update-profil-penyewa" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama-lengkap">Nama Lengkap</label>
                        <input type="text" id="nama-lengkap" name="nama-lengkap" value="{{ $user->nama_user }}" placeholder="Nama Anda">
                        @error('nama-lengkap')
                            <small style="color: #dc2626;">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" placeholder="alamat@email.com">
                        @error('email')
                            <small style="color: #dc2626;">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="telepon">Nomor Telepon</label>
                        <input type="text" id="telepon" name="telepon" value="{{ $user->nomor_telepon ?? old('telepon', '') }}" placeholder="08xxxxxxxxxx">
                        @error('telepon')
                            <small style="color: #dc2626;">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <hr style="margin: 40px 0; border: none; border-top: 1.5px solid #f1f5f9;">
                    
                    <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 24px;">Ubah Password <span style="font-weight: 400; font-size: 14px; color: #94a3b8;">(Opsional)</span></h3>
                    
                    <div class="form-group">
                        <label for="password-lama">Password Lama</label>
                        <div class="password-wrapper">
                            <input type="password" id="password-lama" name="password-lama" placeholder="Password saat ini">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('password-lama')"></i>
                        </div>
                        @error('password-lama')
                            <small style="color: #dc2626;">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-baru">Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" id="password-baru" name="password-baru" placeholder="Minimal 6 karakter">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('password-baru')"></i>
                        </div>
                        @error('password-baru')
                            <small style="color: #dc2626;">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-konfirmasi">Konfirmasi Password Baru</label>
                        <div class="password-wrapper">
                            <input type="password" id="password-konfirmasi" name="password-konfirmasi" placeholder="Ulangi password baru">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('password-konfirmasi')"></i>
                        </div>
                        @error('password-konfirmasi')
                            <small style="color: #dc2626;">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-submit blue">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </form>
            </section>
            
        </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = input.parentElement.querySelector('.toggle-password');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

function submitPhoto() {
    Swal.fire({
        title: 'Mengunggah...',
        text: 'Mohon tunggu sebentar',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading()
        }
    });
    document.getElementById('profile-photo-form').submit();
}
</script>

@endsection