<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function welcome()
    {
        return redirect('/login');
    }

    public function login(Request $request)
    {
        $role = $request->input('role');

        if ($role == 'penyewa') {
            return redirect('/masukPenyewa');
        } elseif ($role == 'pemilik') {
            return redirect('/masukPemilik');
        } else {
            return back()->withErrors(['role' => 'Role tidak valid']);
        }
    }

    public function dashboardPenyewa()
    {
        // Auto-complete expired bookings
        \App\Models\Booking::autoCompleteExpired();

        $penyewaId = session('user.id');
        
        // Get statistics
        $kosAktif = \App\Models\Booking::where('penyewa_id', $penyewaId)
            ->where('status', 'aktif')
            ->count();
        
        $pembayaranPending = \App\Models\Pembayaran::whereHas('booking', function($q) use ($penyewaId) {
            $q->where('penyewa_id', $penyewaId);
        })->where('status', 'pending')->count();
        
        $pesanBaru = 0; // Placeholder for messages feature
        
        $wishlistCount = \App\Models\Wishlist::where('penyewa_id', $penyewaId)->count();
        
        $bookingAktif = \App\Models\Booking::where('penyewa_id', $penyewaId)
            ->whereIn('status', ['aktif', 'menunggu_konfirmasi'])
            ->count();
        
        // Get wishlist IDs for current user
        $wishlistKosIds = \App\Models\Wishlist::where('penyewa_id', $penyewaId)
            ->pluck('kos_id')
            ->toArray();
        
        // Get available kos (limit 3 for recommendations)
        $kosList = \App\Models\Kos::with(['pemilik', 'reviews'])
            ->where('status', 'aktif')
            ->withCount('reviews')
            ->limit(3)
            ->get();
        
        $totalKosTersedia = \App\Models\Kos::where('status', 'aktif')->count();
        
        // Get recent activity (mix of bookings and payments)
        $recentBookings = \App\Models\Booking::where('penyewa_id', $penyewaId)
            ->with(['kamar.kos'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function($booking) {
                return [
                    'type' => 'booking',
                    'title' => 'Booking Baru',
                    'description' => 'Anda membuat booking di ' . ($booking->kamar->kos->nama_kos ?? 'Kos'),
                    'date' => $booking->created_at,
                    'status' => $booking->status,
                    'link' => '/booking-aktif'
                ];
            });

        $recentActivity = $recentBookings; // For now just bookings, can merge others if needed
        
        // Get notifications
        $notifications = \App\Models\Notifikasi::where('user_id', $penyewaId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $penyewaId)
            ->where('is_read', false)
            ->count();
            
        return view('penyewa.DashboardPenyewa', compact(
            'kosAktif',
            'pembayaranPending',
            'pesanBaru',
            'wishlistCount',
            'bookingAktif',
            'kosList',
            'totalKosTersedia',
            'recentActivity',
            'wishlistKosIds',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    public function masukPenyewa()
    {
        return view('auth.login');
    }

    public function loginAdmin()
    {
        return view('auth.loginAdmin');
    }

    public function masukPemilik()
    {
        return redirect('/dashboard-pemilik');
    }

    public function daftar(Request $request)
    {
        // Simple register without database
        return redirect('/')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logoutAdmin(Request $request)
    {
        // Simple logout - redirect to admin login
        session()->flush();
        return redirect('/login-admin');
    }

    public function logoutPemilik(Request $request)
    {
        // Simple logout - redirect to main login
        session()->flush();
        return redirect('/');
    }

    public function logoutPenyewa(Request $request)
    {
        // Simple logout - redirect to main login
        session()->flush();
        return redirect('/');
    }

    public function hubungiPemilik($id)
    {
        $kos = \App\Models\Kos::with('pemilik')->findOrFail($id);
        
        // If AJAX request, return only the modal content
        if (request()->ajax() || request()->wantsJson()) {
            return view('penyewa.partials.contactOwnerContent', compact('kos'));
        }
        
        // Otherwise return full page
        return view('penyewa.hubungiPemilik', compact('kos'));
    }

    public function notifPembayaranBerhasil()
    {
        return view('penyewa.notifPembayaranBerhasil');
    }

    public function index()
    {
        return view('login');
    }

    public function loginAdminView()
    {
        return view('loginAdmin');
    }

    public function dashboardAdmin()
    {
        $totalUsers = \App\Models\data_user_model::count();
        $totalPemilik = \App\Models\data_user_model::where('role', 'pemilik')->count();
        $totalPenyewa = \App\Models\data_user_model::where('role', 'penyewa')->count();
        $totalKos = \App\Models\Kos::count();
        $totalBookingAktif = \App\Models\Booking::where('status', 'aktif')->count();
        $totalKeluhan = \App\Models\Keluhan::where('status', 'pending')->count();
        
        // Get recent transactions
        $recentTransactions = \App\Models\Booking::with(['penyewa', 'kamar.kos'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        // Get notifications for admin (if any specific admin notifications exist)
        // For now assuming admin might see system alerts, but if 'notifikasi' table is user-bound,
        // we need to know the admin's user_id. Assuming session('user.id') works for admin too.
        $adminId = session('user.id');
        $notifications = \App\Models\Notifikasi::where('user_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $adminId)
            ->where('is_read', false)
            ->count();
        
        return view('admin.DashboardAdmin', compact(
            'totalUsers',
            'totalPemilik',
            'totalPenyewa',
            'totalKos',
            'totalBookingAktif',
            'totalKeluhan',
            'recentTransactions',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    public function adminDataPengguna()
    {
        return view('admin.admin_manage_users');
    }

    public function adminDataKos()
    {
        return view('admin.admin_manage_kos');
    }

    public function adminTransaksi()
    {
        return view('admin.admin_transaksi');
    }

    public function adminKeluhan()
    {
        return view('admin.admin_keluhan');
    }

    public function adminLaporan()
    {
        return view('admin.admin_laporan');
    }

    public function tambahDataUser()
    {
        return view('admin.tambahDataUser');
    }

    public function editDataUser()
    {
        return view('admin.editDataUser');
    }

    public function tambahDataKos()
    {
        return view('admin.tambahDataKos');
    }

    public function editDataKos()
    {
        return view('admin.editDataKos');
    }

    public function adminProfil()
    {
        $adminId = session('admin.id');
        $admin = \App\Models\data_user_model::find($adminId);
        $notifikasis = \App\Models\Notifikasi::where('user_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.profil_admin', compact('admin', 'notifikasis'));
    }

    public function dashboardPemilik()
    {
        // Auto-complete expired bookings
        \App\Models\Booking::autoCompleteExpired();

        $pemilikId = session('user.id');
        
        // 1. Stats
        $totalKos = \App\Models\Kos::where('pemilik_id', $pemilikId)->count();
        
        $totalKamar = \App\Models\Kamar::whereHas('kos', function($q) use ($pemilikId) {
            $q->where('pemilik_id', $pemilikId);
        })->count();
        
        $bookingAktif = \App\Models\Booking::whereHas('kamar.kos', function($q) use ($pemilikId) {
            $q->where('pemilik_id', $pemilikId);
        })->where('status', 'aktif')->count();
        
        $keluhanBaru = \App\Models\Keluhan::whereHas('kos', function($q) use ($pemilikId) {
            $q->where('pemilik_id', $pemilikId);
        })->where('status', 'pending')->count();
        
        $pendapatanBulanIni = \App\Models\Pembayaran::whereHas('booking.kamar.kos', function($q) use ($pemilikId) {
            $q->where('pemilik_id', $pemilikId);
        })
        ->whereMonth('tanggal_bayar', now()->month)
        ->whereYear('tanggal_bayar', now()->year)
        ->where('status', 'verified')
        ->sum('jumlah');
        
        // Average Rating
        $ratingRataRata = \App\Models\Review::whereHas('kos', function($q) use ($pemilikId) {
            $q->where('pemilik_id', $pemilikId);
        })->avg('rating');
        
        $ratingRataRata = number_format($ratingRataRata ?? 0, 1);

        // 2. Recent Transactions / Activities
        // Fetch recent bookings (orders)
        $recentBookings = \App\Models\Booking::with(['penyewa', 'kamar.kos'])
            ->whereHas('kamar.kos', function($q) use ($pemilikId) {
                $q->where('pemilik_id', $pemilikId);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get notifications
        $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->where('is_read', false)
            ->count();
            
        return view('pemilik.DashboardPemilik', compact(
            'totalKos',
            'totalKamar',
            'bookingAktif',
            'keluhanBaru',
            'pendapatanBulanIni',
            'ratingRataRata',
            'recentBookings',
            'notifications',
            'unreadNotificationsCount'
        ));
    }

    public function pemilikManajemenKos()
    {
        $pemilikId = session('user.id');
        $kos = \App\Models\Kos::where('id_pemilik', $pemilikId)->get();
        
        $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->where('is_read', false)
            ->count();
            
        return view('pemilik.manajemen_kos', compact('kos', 'notifications', 'unreadNotificationsCount'));
    }

    public function pemilikTambahKos()
    {
        $pemilikId = session('user.id');
        
        $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->where('is_read', false)
            ->count();
            
        return view('pemilik.tambahKos', compact('notifications', 'unreadNotificationsCount'));
    }

    public function tambahKos(Request $request)
    {
        // Logic untuk menambah kos baru
        return redirect('/manajemen-kos')->with('success', 'Kos berhasil ditambahkan!');
    }

    public function pemilikKelolaPesanan()
    {
        $pemilikId = session('user.id');
        
        $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->where('is_read', false)
            ->count();
            
        return view('pemilik.kelola_pesanan', compact('notifications', 'unreadNotificationsCount'));
    }

    public function konfirmasiPesanan(Request $request, $nama)
    {
        // Untuk sementara, redirect ke halaman kelola pesanan
        return redirect('/kelola-pesanan');
    }

    public function pemilikKelolaPesananFilter($filter)
    {
        // Pass the filter to the view
        return view('pemilik.kelola_pesanan', compact('filter'));
    }

    public function setKeluhanDiproses(Request $request, $nama)
    {
        // Untuk sementara, redirect ke halaman keluhan kos
        return redirect('/keluhan-kos');
    }

    public function tandaKeluhanSelesai(Request $request, $nama)
    {
        // Untuk sementara, redirect ke halaman keluhan kos
        return redirect('/keluhan-kos');
    }

    public function pemilikVerifikasiPembayaran()
    {
        $pembayarans = \App\Models\Transaksi::whereHas('booking', function($q) {
            $q->whereHas('kamar', function($q) {
                $q->where('id_pemilik', session('user.id'));
            });
        })->where('status', 'menunggu_verifikasi')->get();

        $pemilikId = session('user.id');
        
        $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->where('is_read', false)
            ->count();

        return view('pemilik.verifikasi_pembayaran', compact('pembayarans', 'notifications', 'unreadNotificationsCount'));
    }

    public function pemilikKeluhanKos()
    {
        $pemilikId = session('user.id');
        
        $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->where('is_read', false)
            ->count();
            
        return view('pemilik.keluhan_kos', compact('notifications', 'unreadNotificationsCount'));
    }

    public function pemilikProfil()
    {
        $pemilikId = session('user.id');
        
        $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->where('is_read', false)
            ->count();
            
        return view('pemilik.profil', compact('notifications', 'unreadNotificationsCount'));
    }

    public function pemilikNotifikasi()
    {
        $pemilikId = session('user.id');
        
        $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->where('is_read', false)
            ->count();
            
        return view('pemilik.notifikasi', compact('notifications', 'unreadNotificationsCount'));
    }

    public function updateProfile(Request $request)
    {
        // Logic untuk update profile
        return redirect('/profil')->with('success', 'Profil berhasil diperbarui!');
    }

    public function changePassword(Request $request)
    {
        // Logic untuk change password
        return redirect('/profil')->with('success', 'Password berhasil diubah!');
    }

    public function updatePhoto(Request $request)
    {
        // Logic untuk update photo
        return redirect('/profil')->with('success', 'Foto profil berhasil diperbarui!');
    }

    public function pemilikManajemenKamar($kos)
    {
        $kosName = str_replace('-', ' ', $kos);
        return view('pemilik.manajemen_kamar', compact('kosName'));
    }

    public function pemilikEditKamar($kamar)
    {
        $kamarName = str_replace('-', ' ', $kamar);
        return view('pemilik.edit_kamar', compact('kamarName'));
    }

    public function pemilikUpdateKamar(Request $request)
    {
        // Untuk sementara, redirect ke manajemen kos dengan pesan sukses
        return redirect('/manajemen-kos')->with('success', 'Kamar berhasil diupdate!');
    }

    public function pemilikTambahKamar()
    {
        $pemilikId = session('user.id');
        
        $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->where('is_read', false)
            ->count();
            
        return view('pemilik.tambahKamar', compact('notifications', 'unreadNotificationsCount'));
    }

    public function tambahKamar(Request $request)
    {
        // Logic untuk menambah kamar baru
        return redirect('/manajemen-kos')->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function pemilikEditKos($kos)
    {
        $kosName = str_replace('-', ' ', $kos);
        return view('pemilik.edit_kos', compact('kosName'));
    }

    public function pemilikUpdateKos(Request $request)
    {
        // Untuk sementara, redirect ke manajemen kos dengan pesan sukses
        return redirect('/manajemen-kos');
    }

    public function lihatBukti($id)
    {
        $pemilikId = session('user.id');
        
        $notifications = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $unreadNotificationsCount = \App\Models\Notifikasi::where('user_id', $pemilikId)
            ->where('is_read', false)
            ->count();
            
        // For now, we'll pass the payment ID to the view
        return view('pemilik.lihat_bukti', compact('id', 'notifications', 'unreadNotificationsCount'));
    }

    public function verifikasiPembayaran(Request $request, $id)
    {
        // For now, just redirect back
        return redirect('/verifikasi-pembayaran');
    }

    public function tolakPembayaran(Request $request, $id)
    {
        // For now, just redirect back
        return redirect('/verifikasi-pembayaran');
    }


    public function penyewaWishlist()
    {
        return view('penyewa.wishlist');
    }

    public function penyewaBooking()
    {
        return view('penyewa.riwayatBooking');
    }

    public function tampilDashboardPenyewa()
    {
        return view('penyewa.DashboardPenyewa');
    }

    public function penyewaMenungguKonfirmasi()
    {
        return view('penyewa.bookingMenungguKonfirmasi');
    }

    public function penyewaBookingAktif()
    {
        return view('penyewa.bookingAktif');
    }

    public function penyewaRiwayatBooking()
    {
        return view('penyewa.riwayatBooking');
    }

    public function penyewaReview()
    {
        return view('penyewa.review');
    }

    public function PenyewatulisReview()
    {
        return view('penyewa.TulisReview');
    }

    public function penyewaFeedback()
    {
        return view('penyewa.feedback');
    }

    public function penyewaPembayaran()
    {
        return view('penyewa.pembayaran');
    }

    public function penyewaProfil()
    {
        $id = session('user.id');
        $user = \App\Models\data_user_model::find($id);
        
        return view('penyewa.profil', compact('user'));
    }

    public function penyewaKeluhan()
    {
        return view('penyewa.submitKeluhan');
    }

    public function penyewaSewaSaya()
    {
        return view('penyewa.sewaSaya');
    }

    public function penyewaDaftarKos()
    {
        return view('penyewa.daftarKos');
    }

    public function penyewaRiwayatSewa()
    {
        return view('penyewa.riwayatSewa');
    }

    public function penyewaDetailKos()
    {
        return view('penyewa.detailKos');
    }

    public function penyewaHubungiPemilik()
    {
        return view('penyewa.hubungiPemilik');
    }

    public function TampilKonfirmasiSewa()
    {
        return view('penyewa.konfirmasiSewa');
    }

    public function PembayaranSewa()
    {
        return view('penyewa.pembayaranBooking');
    }



    public function perpanjangSewa()
    {
        return view('penyewa.perpanjangSewa');
    }

}
