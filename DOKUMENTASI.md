# Dokumentasi Project KosConnect

## Overview
Project KosConnect adalah aplikasi sistem manajemen kontrakan/kos dengan 3 role pengguna:
1. **Admin** - Mengelola seluruh sistem
2. **Pemilik** - Mengelola properti kos mereka
3. **Penyewa** - Mencari dan menyewa kos

## Struktur Project

### Controllers
- **MenuController** (`app/Http/Controllers/MenuController.php`)
  - Mengatur semua routing dan view untuk seluruh aplikasi
  - Tidak menggunakan database (sesuai permintaan)

### Routes (`routes/web.php`)
Semua routes telah dikonfigurasi dengan prefix:
- `/` - Login & Register
- `/admin/*` - Dashboard Admin
- `/pemilik/*` - Dashboard Pemilik
- `/penyewa/*` - Dashboard Penyewa

### Views yang Telah Dibuat

#### Login & Register
1. `resources/views/login.blade.php` - Halaman login user dengan pilihan role
2. `resources/views/register.blade.php` - Halaman registrasi user baru
3. `resources/views/loginAdmin.blade.php` - Halaman login khusus admin

#### Dashboard Admin (`resources/views/admin/`)
1. `dashboard.blade.php` - Dashboard utama admin dengan statistik
2. `kelola-pengguna.blade.php` - Manajemen data pengguna
3. `kelola-kontrakan.blade.php` - Manajemen data kos
4. `laporan.blade.php` - Halaman laporan (placeholder)
5. `pengaturan.blade.php` - Halaman pengaturan (placeholder)
6. `detail-kontrakan.blade.php` - Detail kontrakan (placeholder)

#### Dashboard Pemilik (`resources/views/pemilik/`)
1. `dashboard.blade.php` - Dashboard utama pemilik dengan statistik
2. `kontrakan-saya.blade.php` - Manajemen kos/kamar pemilik
3. `tambah-kontrakan.blade.php` - Form tambah kontrakan (placeholder)
4. `penyewa.blade.php` - Daftar penyewa (placeholder)
5. `pengaturan.blade.php` - Pengaturan akun (placeholder)
6. `detail-kontrakan.blade.php` - Detail kontrakan (placeholder)

#### Dashboard Penyewa (`resources/views/penyewa/`)
1. `dashboard.blade.php` - Dashboard utama penyewa dengan rekomendasi kos
2. `cari-kontrakan.blade.php` - Halaman pencarian kos (placeholder)
3. `detail-kontrakan.blade.php` - Detail kos (placeholder)
4. `kontrakan-saya.blade.php` - Kos yang sedang disewa (placeholder)
5. `riwayat.blade.php` - Riwayat transaksi (placeholder)
6. `pengaturan.blade.php` - Pengaturan akun (placeholder)
7. `form-pembayaran.blade.php` - Form pembayaran (placeholder)
8. `konfirmasi-pembayaran.blade.php` - Konfirmasi pembayaran (placeholder)
9. `bukti-pembayaran.blade.php` - Bukti pembayaran (placeholder)
10. `detail-riwayat.blade.php` - Detail riwayat (placeholder)
11. `profil-kontrakan.blade.php` - Profil kontrakan (placeholder)

## Fitur Desain

### Color Scheme
- Primary: Blue (#3498db) & Purple (#667eea, #764ba2)
- Success: Green (#27ae60)
- Warning: Yellow (#f39c12)
- Danger: Red (#e74c3c)
- Dark: Navy (#2c3e50)

### Typography
- Font Family: Poppins (Google Fonts)
- Menggunakan Font Awesome untuk icons

### Layout
- **Admin & Pemilik**: Sidebar navigation dengan main content area
- **Penyewa**: Top navbar dengan horizontal menu
- Responsive dan modern design

## Cara Menjalankan

1. Pastikan Laravel sudah terinstall
2. Jalankan server development:
   ```bash
   php artisan serve
   ```
3. Akses aplikasi di browser:
   - Login User: `http://localhost:8000/`
   - Login Admin: `http://localhost:8000/login-admin`
   - Register: `http://localhost:8000/register`

## Routes Tersedia

### Public Routes
- `GET /` - Login
- `GET /login` - Login
- `GET /register` - Register
- `GET /login-admin` - Login Admin

### Admin Routes (prefix: /admin)
- `GET /admin/dashboard` - Dashboard Admin
- `GET /admin/data-pengguna` - Kelola Pengguna
- `GET /admin/data-kos` - Kelola Kos
- `GET /admin/transaksi` - Transaksi
- `GET /admin/keluhan` - Keluhan
- `GET /admin/laporan` - Laporan

### Pemilik Routes (prefix: /pemilik)
- `GET /pemilik/dashboard` - Dashboard Pemilik
- `GET /pemilik/manajemen-kos` - Manajemen Kos
- `GET /pemilik/pesanan-masuk` - Pesanan Masuk
- `GET /pemilik/pembayaran` - Pembayaran
- `GET /pemilik/keluhan-kos` - Keluhan
- `GET /pemilik/profil-saya` - Profil

### Penyewa Routes (prefix: /penyewa)
- `GET /penyewa/dashboard` - Dashboard Penyewa
- `GET /penyewa/daftar-kos` - Daftar Kos
- `GET /penyewa/wishlist` - Wishlist
- `GET /penyewa/booking` - Booking
- `GET /penyewa/sewa-saya` - Sewa Saya
- `GET /penyewa/review` - Review
- `GET /penyewa/feedback` - Feedback
- `GET /penyewa/pembayaran` - Pembayaran
- `GET /penyewa/profil` - Profil

## Catatan Penting

1. **Tidak Menggunakan Database**: Semua data ditampilkan secara static/hardcoded sesuai permintaan
2. **Desain Mengikuti Screenshot**: View dibuat sesuai dengan desain yang ada di folder "Desain Web FrameWork"
3. **Semua Routes Melalui MenuController**: Centralized controller untuk memudahkan manajemen
4. **Placeholder Views**: Beberapa view dibuat sebagai placeholder untuk development selanjutnya

## Status Development

✅ MenuController - Selesai
✅ Login & Register Views - Selesai
✅ Admin Dashboard Views - Selesai (3 utama + 3 placeholder)
✅ Pemilik Dashboard Views - Selesai (2 utama + 4 placeholder)
✅ Penyewa Dashboard Views - Selesai (1 utama + 10 placeholder)
✅ Routes Configuration - Selesai

## Next Steps (Untuk Development Selanjutnya)

1. Implementasi database dan models
2. Tambahkan authentication dan authorization
3. Implementasi CRUD functionality
4. Tambahkan validasi form
5. Implementasi upload gambar untuk properti kos
6. Tambahkan sistem pembayaran
7. Implementasi search dan filter
8. Tambahkan sistem notifikasi
9. Implementasi review dan rating
10. Optimasi responsive design

---
Dibuat: 10 November 2025
Framework: Laravel
Designer: Berdasarkan folder "Desain Web FrameWork"
