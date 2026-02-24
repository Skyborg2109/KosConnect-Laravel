# Daftar Code Session di MenuController.php

## 1. Admin Session Check
```php
if (session()->exists('admin') && session('admin.role') == 'admin'){
    // Akses diizinkan
}
return redirect('/login-admin');
```

**Method yang menggunakan Admin Session:**
- `dashboardAdmin()`
- `adminDataPengguna()`
- `adminDataKos()`
- `adminTransaksi()`
- `adminKeluhan()`
- `adminLaporan()`
- `tambahDataUser()`
- `editDataUser()`
- `tambahDataKos()`
- `editDataKos()`

---

## 2. Pemilik Session Check
```php
if (session()->exists('user') && session('user.role') == 'pemilik'){
    // Akses diizinkan
}
return redirect('/');
```

**Method yang menggunakan Pemilik Session (24 method):**
- `dashboardPemilik()`
- `pemilikManajemenKos()`
- `pemilikTambahKos()`
- `tambahKos()`
- `pemilikKelolaPesanan()`
- `pemilikVerifikasiPembayaran()`
- `pemilikKeluhanKos()`
- `pemilikProfil()`
- `pemilikNotifikasi()`
- `updateProfile()`
- `changePassword()`
- `updatePhoto()`
- `pemilikManajemenKamar()`
- `pemilikEditKamar()`
- `pemilikUpdateKamar()`
- `pemilikTambahKamar()`
- `tambahKamar()`
- `pemilikEditKos()`
- `pemilikUpdateKos()`
- `lihatBukti()`
- `verifikasiPembayaran()`
- `tolakPembayaran()`

---

## 3. Penyewa Session Check
```php
if (session()->exists('user') && session('user.role') == 'penyewa'){
    // Akses diizinkan
}
return redirect('/');
```

**Method yang menggunakan Penyewa Session (24 method):**
- `dashboardPenyewa()`
- `penyewaWishlist()`
- `penyewaBooking()`
- `tampilDashboardPenyewa()`
- `penyewaMenungguKonfirmasi()`
- `penyewaBookingAktif()`
- `penyewaRiwayatBooking()`
- `penyewaReview()`
- `PenyewatulisReview()`
- `penyewaFeedback()`
- `penyewaPembayaran()`
- `penyewaProfil()`
- `penyewaKeluhan()`
- `penyewaSewaSaya()`
- `penyewaDaftarKos()`
- `penyewaRiwayatSewa()`
- `penyewaDetailKos()`
- `penyewaHubungiPemilik()`
- `TampilKonfirmasiSewa()`
- `PembayaranSewa()`
- `notifPembayaranBerhasil()`
- `perpanjangSewa()`

---

## Session Data Structure (dari LoginController)

### Admin Session
```php
Session::put('admin', [
    'login' => true,
    'id' => $user->id,
    'email' => $user->email,
    'name' => $user->nama_user,
    'role' => 'admin',
    'login_time' => now(),
]);
```

### Pemilik/Penyewa Session
```php
Session::put('user', [
    'login' => true,
    'id' => $user->id,
    'email' => $user->email,
    'name' => $user->nama_user,
    'role' => $user->role,  // 'pemilik' atau 'penyewa'
    'login_time' => now(),
]);
```

---

## Cara Mengakses Session Data di View

### Mengakses data Admin
```blade
{{ session('admin.id') }}
{{ session('admin.email') }}
{{ session('admin.name') }}
{{ session('admin.role') }}
{{ session('admin.login_time') }}
```

### Mengakses data Pemilik/Penyewa
```blade
{{ session('user.id') }}
{{ session('user.email') }}
{{ session('user.name') }}
{{ session('user.role') }}
{{ session('user.login_time') }}
```

### Mengakses seluruh session array
```blade
@if(session()->has('user'))
    <p>ID: {{ session('user')['id'] }}</p>
    <p>Email: {{ session('user')['email'] }}</p>
@endif
```

---

## Cara Destroy/Logout Session

```php
// Logout Admin
session()->flush();
return redirect('/login-admin');

// Logout Pemilik
session()->flush();
return redirect('/');

// Logout Penyewa
session()->flush();
return redirect('/');
```

---

## Total Protected Methods: 58
- Admin: 10 methods
- Pemilik: 24 methods
- Penyewa: 24 methods
