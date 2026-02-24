<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\EditProfilController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SocialAuthController;
// Test route to check kos data
Route::get('/test-kos', function() {
    $kosList = \App\Models\Kos::with(['pemilik', 'reviews'])
        ->where('status', 'aktif')
        ->withCount('reviews')
        ->limit(3)
        ->get();
    
    return response()->json([
        'count' => $kosList->count(),
        'data' => $kosList
    ]);
});

// Public Routes
Route::get('/', [MenuController::class, 'welcome']);
Route::get('/login', [MenuController::class, 'masukPenyewa']);
Route::post('/masuk', [\App\Http\Controllers\LoginController::class, 'masuk']);
Route::get('/login-admin', [MenuController::class, 'loginAdmin']);
Route::post('/masuk-admin', [\App\Http\Controllers\LoginController::class, 'masukAdmin']);
Route::get('/masukPenyewa', [MenuController::class, 'masukPenyewa']);
Route::get('/masukPemilik', [MenuController::class, 'masukPemilik']);
Route::post('/daftar', [RegisterController::class, 'daftarLagi']);


// Social Authentication Routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);
Route::get('/auth/twitter', [SocialAuthController::class, 'redirectToTwitter']);
Route::get('/auth/twitter/callback', [SocialAuthController::class, 'handleTwitterCallback']);

// OTP Verification Routes
Route::get('/verify-otp', [\App\Http\Controllers\OtpController::class, 'showVerificationForm']);
Route::post('/verify-otp', [\App\Http\Controllers\OtpController::class, 'verifyOtp']);
Route::post('/resend-otp', [\App\Http\Controllers\OtpController::class, 'resendOtp']);
Route::get('/verify-email-link/{token}', [\App\Http\Controllers\OtpController::class, 'verifyLink']);

// Google Confirmation Page
Route::get('/auth/google/confirm', [SocialAuthController::class, 'showConfirmation'])->name('google.confirm');
Route::get('/auth/google/confirm/process', [SocialAuthController::class, 'processConfirmation'])->name('google.confirm.process');

// Admin Routes (Protected by cek.role middleware)
Route::middleware(['cek.role:admin'])->group(function () {
    Route::get('/dashboard-admin', [MenuController::class, 'dashboardAdmin']);
    // Laporan Export Route
    Route::get('/laporan/export', [KosController::class, 'exportLaporan']);
    
    Route::post('/logout-admin', [KosController::class, 'logoutAdmin']);
    
    // User Management
    Route::get('/data-pengguna', [DataController::class, 'dataPengguna']);
    Route::get('/tambahDataUser', [MenuController::class, 'tambahDataUser']);
    Route::post('/store-user', [DataController::class, 'storeUser']);
    Route::get('/editDataUser/{id}', [DataController::class, 'editDataUser']);
    Route::post('/update-user/{id}', [DataController::class, 'updateUser']);
    Route::post('/delete-user/{id}', [DataController::class, 'deleteUser']);
    Route::post('/toggle-status-user/{id}', [DataController::class, 'toggleStatusUser']);
    
    // Kos Management
    Route::get('/data-kos', [DataController::class, 'dataKos']);
    Route::get('/tambahDataKos', [MenuController::class, 'tambahDataKos']);
    Route::post('/store-kos-admin', [DataController::class, 'storeKosAdmin']);
    Route::get('/editDataKos', [MenuController::class, 'editDataKos']);
    Route::post('/update-kos-admin/{id}', [DataController::class, 'updateKosAdmin']);
    Route::delete('/delete-kos/{id}', [KosController::class, 'deleteKos']);
    
    // Transactions, Complaints, Reports
    Route::get('/transaksi', [KosController::class, 'adminTransaksi']);
    Route::post('/transaksi/verify/{id}', [KosController::class, 'adminVerifikasiPembayaran']);
    Route::post('/transaksi/reject/{id}', [KosController::class, 'adminTolakPembayaran']);
    Route::get('/keluhan', [KosController::class, 'adminKeluhan']);
    Route::get('/laporan', [KosController::class, 'adminLaporan']);
    
    // Notifications
    Route::get('/admin/notifications', [\App\Http\Controllers\NotifikasiController::class, 'getAdminNotifications']);
    Route::post('/admin/notifications/{id}/read', [\App\Http\Controllers\NotifikasiController::class, 'markAsRead']);
    Route::post('/admin/notifications/read-all', [\App\Http\Controllers\NotifikasiController::class, 'markAllAsRead']);
    
    // Profile
    Route::get('/profil-admin', [MenuController::class, 'adminProfil']);
    Route::post('/update-profil-admin', [\App\Http\Controllers\EditProfilController::class, 'updateProfilAdmin']);
});

// Pemilik Routes (Protected by cek.role middleware)
Route::middleware(['cek.role:pemilik'])->group(function () {
    Route::get('/dashboard-pemilik', [MenuController::class, 'dashboardPemilik']);
    Route::post('/logout-pemilik', [MenuController::class, 'logoutPemilik']);
    
    // Kos Management
    Route::get('/pemilik/manajemen-kos', [KosController::class, 'pemilikManajemenKos']);
    Route::get('/pemilik/tambah-kos', [MenuController::class, 'pemilikTambahKos']);
    Route::post('/pemilik/store-kos', [KosController::class, 'tambahKos']);
    Route::post('/pemilik/update-kos', [KosController::class, 'pemilikUpdateKos']);
    Route::delete('/pemilik/delete-kos/{id}', [KosController::class, 'deleteKos']);
    
    // Kamar Management
    Route::get('/pemilik/manajemen-kamar/{kosId}', [KosController::class, 'pemilikManajemenKamar']);
    Route::post('/pemilik/tambah-kamar', [KosController::class, 'tambahKamar']);

    Route::post('/pemilik/update-kamar', [KosController::class, 'pemilikUpdateKamar']);
    
    // Booking Management
    Route::get('/pemilik/kelola-pesanan', [KosController::class, 'pemilikKelolaPesanan']);
    Route::post('/pemilik/konfirmasi-pesanan/{id}', [KosController::class, 'konfirmasiPesanan']);
    Route::post('/pemilik/tolak-pesanan/{id}', [KosController::class, 'tolakPesanan']);
    
    // Payment Verification
    Route::get('/pemilik/verifikasi-pembayaran', [KosController::class, 'pemilikVerifikasiPembayaran']);
    Route::post('/pemilik/verifikasi-pembayaran/{id}', [KosController::class, 'verifikasiPembayaran']);
    Route::post('/pemilik/tolak-pembayaran/{id}', [KosController::class, 'tolakPembayaran']);
    Route::get('/pemilik/lihat-bukti/{id}', [KosController::class, 'lihatBukti']);
    
    // Complaint Management
    Route::get('/pemilik/keluhan-kos', [KosController::class, 'pemilikKeluhanKos']);
    Route::post('/pemilik/keluhan/{id}/diproses', [KosController::class, 'setKeluhanDiproses']);
    Route::post('/pemilik/keluhan/{id}/selesai', [KosController::class, 'tandaKeluhanSelesai']);
    
    // Notifications
    Route::post('/pemilik/notifications/read-all', [\App\Http\Controllers\NotifikasiController::class, 'markAllAsRead']);

    // Profile
    Route::get('/profil-pemilik', [MenuController::class, 'pemilikProfil']);
    Route::post('/update-profil-pemilik', [\App\Http\Controllers\EditProfilController::class, 'updateProfilPemilik']);
    Route::post('/update-photo', [\App\Http\Controllers\EditProfilController::class, 'updatePhoto']);
});

// Penyewa Routes (Protected by cek.role middleware)
Route::middleware(['cek.role:penyewa'])->group(function () {
    Route::get('/dashboard-penyewa', [MenuController::class, 'dashboardPenyewa']);
    Route::post('/logout-penyewa', [PenyewaController::class, 'logoutPenyewa']);

    // Booking
    Route::get('/tampilKonfirmasiSewa/{id}', [PenyewaController::class, 'tampilKonfirmasiSewa']);
    
    // Kos Browsing
    Route::get('/daftarkos', [PenyewaController::class, 'daftarKos']);
    Route::get('/detailKos/{id}', [PenyewaController::class, 'detailKos']);
    Route::get('/hubungiPemilik/{id}', [MenuController::class, 'hubungiPemilik']);
    
    // Wishlist
    Route::post('/toggle-wishlist', [PenyewaController::class, 'toggleWishlist']);
    Route::get('/wishlist', [PenyewaController::class, 'wishlist']);
    Route::post('/wishlist/add/{kosId}', [PenyewaController::class, 'addToWishlist']);
    Route::delete('/wishlist/remove-all', [PenyewaController::class, 'removeAllFromWishlist']);
    Route::delete('/wishlist/remove/{kosId}', [PenyewaController::class, 'removeFromWishlist']);
    
    // Other features
    Route::get('/api/kos/{id}/kamar', [PenyewaController::class, 'getKamarsByKos']);
    Route::get('/api/kos/search', [PenyewaController::class, 'searchKosJson']);
    Route::get('/konfirmasiSewa/{kamarId}', [PenyewaController::class, 'konfirmasiSewa']);
    Route::post('/store-booking', [PenyewaController::class, 'storeBooking']);
    
    // Payment
    Route::get('/pembayaran-sewa/{bookingId}', [PenyewaController::class, 'pembayaranSewa']);
    Route::post('/store-pembayaran', [PenyewaController::class, 'storePembayaran']);
    Route::get('/notif-pembayaran-berhasil', [MenuController::class, 'notifPembayaranBerhasil']);
    
    // Booking History
    Route::get('/booking-aktif', [PenyewaController::class, 'bookingAktif']);
    Route::get('/menunggu-konfirmasi', [PenyewaController::class, 'menungguKonfirmasi']);
    Route::get('/menunggu-pembayaran', [PenyewaController::class, 'menungguPembayaran']);
    Route::get('/riwayat-booking', [PenyewaController::class, 'riwayatBooking']);
    Route::post('/booking/selesai/{id}', [PenyewaController::class, 'selesaikanSewa']);
    Route::post('/booking/cancel/{id}', [PenyewaController::class, 'batalkanBooking']);
    
    // Complaints
    Route::get('/submitKeluhan', [PenyewaController::class, 'submitKeluhan']);
    Route::post('/store-keluhan', [PenyewaController::class, 'storeKeluhan']);
    
    // Reviews
    Route::get('/tulis-review/{kosId}', [PenyewaController::class, 'tulisReview']);
    Route::post('/store-review', [PenyewaController::class, 'storeReview']);
    Route::get('/review', [PenyewaController::class, 'review']);
    
    // Notifications
    Route::get('/notifikasi', [PenyewaController::class, 'notifikasi']);
    Route::post('/notifikasi/{id}/read', [PenyewaController::class, 'markNotificationAsRead']);
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotifikasiController::class, 'markAllAsRead']);
    
    // Profile
    Route::get('/profil-penyewa', [MenuController::class, 'penyewaProfil']);
    Route::get('/edit-profil-penyewa', [EditProfilController::class, 'editProfil']);
    Route::post('/update-profil-penyewa', [EditProfilController::class, 'updateProfil']);
    Route::post('/update-profil-penyewa-photo', [EditProfilController::class, 'updatePhoto']);

    // Static/Simple Views
    Route::get('/feedback', [KosController::class, 'showFeedback']);
    Route::post('/feedback/submit', [KosController::class, 'submitFeedback']);
    Route::get('/pembayaran', [PenyewaController::class, 'pembayaran']);
    Route::get('/sewaSaya', function() { return redirect('/booking-aktif'); });
    Route::get('/perpanjang-sewa/{id}', [PenyewaController::class, 'perpanjangSewa']);
    Route::post('/perpanjang-sewa', [PenyewaController::class, 'storePerpanjangan']);
    Route::get('/riwayatSewa', function() { return redirect('/riwayat-booking'); });
});