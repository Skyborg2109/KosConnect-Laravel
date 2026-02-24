<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kos;
use App\Models\Kamar;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Keluhan;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Notifikasi;
use App\Models\User;
use App\Models\data_user_model;
use Illuminate\Support\Facades\Storage;

class PenyewaController extends Controller
{
    public function daftarKos(Request $request)
    {
        $query = Kos::with(['kamar', 'reviews'])
            ->where('status', 'aktif');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kos', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%")
                  ->orWhere('fasilitas', 'like', "%{$search}%");
            });
        }
        
        // Filter by kota
        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }
        
        // Filter by price range
        if ($request->filled('harga')) {
            $harga = $request->harga;
            if ($harga == 'murah') {
                $query->where('harga_dasar', '<=', 1000000);
            } elseif ($harga == 'menengah') {
                $query->where('harga_dasar', '>', 1000000)->where('harga_dasar', '<=', 2000000);
            }
        }

        // Filter by facilities
        if ($request->filled('fasilitas')) {
            $fasilitasSlug = explode(',', $request->fasilitas);
            
            // Map slugs to possible database values (including abbreviations)
            $mapping = [
                'wifi' => ['WiFi', 'Wifi', 'wifi', 'internet', 'wi-fi'],
                'ac' => ['AC', 'Ac', 'ac', 'pendingin'],
                'kamar_mandi_dalam' => ['Kamar Mandi Dalam', 'KM Dalam', 'km dalam', 'kamar mandi'],
                'parkir' => ['Parkir', 'Garasi', 'Lahan Parkir', 'parkir']
            ];

            foreach ($fasilitasSlug as $slug) {
                if (isset($mapping[$slug])) {
                    $values = $mapping[$slug];
                    $query->where(function($q) use ($values) {
                        foreach ($values as $val) {
                            $q->orWhere('fasilitas', 'like', "%{$val}%");
                        }
                    });
                } else {
                    $query->where('fasilitas', 'like', "%{$slug}%");
                }
            }
        }
        
        $kos = $query->paginate(12);
        $penyewaId = session('user.id');
        
        // Get wishlist IDs for current user
        $wishlistKosIds = Wishlist::where('penyewa_id', $penyewaId)
            ->pluck('kos_id')
            ->toArray();
        
        return view('penyewa.daftarKos', compact('kos', 'wishlistKosIds'));
    }
    
    public function detailKos(Request $request, $id)
    {
        $kos = Kos::with(['kamar' => function($query) {
                $query->where('status', 'tersedia');
            }, 'reviews.penyewa', 'pemilik', 'images'])
            ->findOrFail($id);
        
        $penyewaId = session('user.id');
        $isWishlisted = Wishlist::where('penyewa_id', $penyewaId)
            ->where('kos_id', $id)
            ->exists();
        
        if ($request->ajax()) {
            return view('penyewa.partials.detailKosContent', compact('kos', 'isWishlisted'));
        }
        
        return view('penyewa.detailKos', compact('kos', 'isWishlisted'));
    }
    
    public function wishlist()
    {
        $penyewaId = session('user.id');
        
        $wishlists = Wishlist::with('kos.kamar')
            ->where('penyewa_id', $penyewaId)
            ->get();
        
        return view('penyewa.wishlist', compact('wishlists'));
    }

    public function toggleWishlist(Request $request)
    {
        $kosId = $request->input('kos_id');
        $penyewaId = session('user.id');
        
        $wishlist = Wishlist::where('penyewa_id', $penyewaId)
            ->where('kos_id', $kosId)
            ->first();
        
        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'success', 'action' => 'removed', 'message' => 'Dihapus dari wishlist']);
        } else {
            Wishlist::create([
                'penyewa_id' => $penyewaId,
                'kos_id' => $kosId
            ]);
            return response()->json(['status' => 'success', 'action' => 'added', 'message' => 'Ditambahkan ke wishlist']);
        }
    }
    
    public function addToWishlist($kosId)
    {
        $penyewaId = session('user.id');
        
        // Check if already in wishlist
        $exists = Wishlist::where('penyewa_id', $penyewaId)
            ->where('kos_id', $kosId)
            ->exists();
        
        if (!$exists) {
            Wishlist::create([
                'penyewa_id' => $penyewaId,
                'kos_id' => $kosId,
            ]);
            
            return response()->json(['success' => true, 'message' => 'Ditambahkan ke wishlist']);
        }
        
        return response()->json(['success' => false, 'message' => 'Sudah ada di wishlist']);
    }
    
    public function removeFromWishlist($kosId)
    {
        $penyewaId = session('user.id');
        
        Wishlist::where('penyewa_id', $penyewaId)
            ->where('kos_id', $kosId)
            ->delete();
        
        return response()->json(['success' => true, 'message' => 'Dihapus dari wishlist']);
    }

    public function removeAllFromWishlist()
    {
        $penyewaId = session('user.id');
        
        Wishlist::where('penyewa_id', $penyewaId)->delete();
        
        return response()->json(['success' => true, 'message' => 'Semua wishlist berhasil dihapus']);
    }

    public function getKamarsByKos($kosId)
    {
        $kamars = Kamar::where('kos_id', $kosId)
            ->where('status', 'tersedia')
            ->get(['id', 'nomor_kamar', 'harga', 'tipe_kamar']);
            
        return response()->json($kamars);
    }
    
    public function konfirmasiSewa($kamarId)
    {
        $kamar = Kamar::with('kos')->findOrFail($kamarId);
        
        if ($kamar->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Kamar tidak tersedia');
        }
        $kos = $kamar->kos;

        // Get all available rooms for this Kos
        $availableKamars = Kamar::where('kos_id', $kos->id)
            ->where('status', 'tersedia')
            ->get();
        
        // Ensure currently selected room is in the list
        if (!$availableKamars->contains('id', $kamar->id)) {
            $availableKamars->push($kamar);
        }
        
        return view('penyewa.konfirmasiSewa', compact('kamar', 'kos', 'availableKamars'));
    }

    public function searchKosJson(Request $request) 
    {
        $query = Kos::with(['pemilik', 'reviews'])->where('status', 'aktif');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kos', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%")
                  ->orWhere('fasilitas', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('harga_min')) {
            $query->where('harga_dasar', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_dasar', '<=', $request->harga_max);
        }

        $kosList = $query->limit(6)->get()->map(function($kos) {
            $avgRating = $kos->averageRating();
            return [
                'id' => $kos->id,
                'nama_kos' => $kos->nama_kos,
                'kota' => $kos->kota,
                'alamat' => $kos->alamat,
                'harga' => $kos->harga_dasar,
                'harga_formatted' => number_format($kos->harga_dasar, 0, ',', '.'),
                'fasilitas' => array_slice($kos->fasilitas ?? [], 0, 3),
                'rating' => number_format($avgRating, 1),
                'full_stars' => floor($avgRating),
                'has_half_star' => ($avgRating - floor($avgRating)) >= 0.5,
                'pemilik_telp' => $kos->pemilik->nomor_telepon ?? ''
            ];
        });

        return response()->json($kosList);
    }
    
    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'durasi_bulan' => 'required|integer|min:1|max:12',
        ]);
        
        $kamar = Kamar::with('kos')->findOrFail($validated['kamar_id']);
        
        if ($kamar->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Kamar tidak tersedia');
        }
        
        // Calculate end date and total price
        $tanggalMulai = \Carbon\Carbon::parse($validated['tanggal_mulai']);
        $tanggalSelesai = $tanggalMulai->copy()->addMonths((int)$validated['durasi_bulan']);
        $totalHarga = $kamar->harga * $validated['durasi_bulan'];
        
        $booking = Booking::create([
            'penyewa_id' => session('user.id'),
            'kamar_id' => $validated['kamar_id'],
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'durasi_bulan' => $validated['durasi_bulan'],
            'total_harga' => $totalHarga,
            'status' => 'menunggu_konfirmasi',
        ]);
        
        // Create notification for pemilik
    Notifikasi::create([
        'user_id' => $kamar->kos->pemilik_id,
        'judul' => 'Booking Baru',
        'pesan' => 'Ada booking baru untuk kamar ' . $kamar->nomor_kamar . ' di ' . $kamar->kos->nama_kos,
        'link' => '/pemilik/kelola-pesanan',
        'tipe' => 'new_booking',
    ]);

    // Create notification for penyewa
    Notifikasi::create([
        'user_id' => session('user.id'),
        'judul' => 'Booking Berhasil',
        'pesan' => 'Booking untuk kamar ' . $kamar->nomor_kamar . ' di ' . $kamar->kos->nama_kos . ' telah diajukan. Menunggu konfirmasi pemilik.',
        'link' => '/menunggu-konfirmasi',
        'tipe' => 'booking_created',
        'is_read' => true, // Mark self-actions as read by default to avoid cluttering badge
    ]);
        
        return redirect('/menunggu-konfirmasi')->with('success', 'Booking berhasil dibuat. Silakan tunggu konfirmasi pemilik.');
    }
    
    public function pembayaranSewa($bookingId)
    {
        $booking = Booking::with('kamar.kos')
            ->where('id', $bookingId)
            ->where('penyewa_id', session('user.id'))
            ->firstOrFail();
        
        return view('penyewa.pembayaranBooking', compact('booking'));
    }
    
    public function storePembayaran(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:booking,id',
            'jumlah' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_bayar' => 'required|date',
        ]);
        
        // Verify booking belongs to penyewa
        $booking = Booking::where('id', $validated['booking_id'])
            ->where('penyewa_id', session('user.id'))
            ->firstOrFail();
        
        // Handle image upload with Cloudinary
        if ($request->hasFile('bukti_transfer')) {
            try {
                $file = $request->file('bukti_transfer');
                if ($file->isValid()) {
                    // Use base64 for Cloudinary upload to avoid path issues
                    $base64 = base64_encode($file->get());
                    $mime = $file->getMimeType();
                    $dataUri = "data:$mime;base64,$base64";
                    
                    $upload = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::uploadApi()->upload($dataUri, [
                        'folder' => 'pembayaran'
                    ]);
                    
                    $validated['bukti_transfer'] = $upload['secure_url'];
                } else {
                    return back()->withErrors(['bukti_transfer' => 'File upload tidak valid.'])->withInput();
                }
            } catch (\Exception $e) {
                \Log::error('Cloudinary Error (Payment): ' . $e->getMessage());
                return back()->with('error', 'Gagal mengupload bukti pembayaran: ' . $e->getMessage())->withInput();
            }
        }
        
        Pembayaran::create($validated);
        
        // Update status booking menjadi verifikasi_pembayaran
        $booking->update(['status' => 'verifikasi_pembayaran']);
        
        // Create notification for pemilik
    Notifikasi::create([
        'user_id' => $booking->kamar->kos->pemilik_id,
        'judul' => 'Pembayaran Baru',
        'pesan' => 'Ada pembayaran baru yang perlu diverifikasi untuk kamar ' . $booking->kamar->nomor_kamar,
        'link' => '/pemilik/verifikasi-pembayaran',
        'tipe' => 'new_payment',
    ]);

    // Create notification for penyewa
    Notifikasi::create([
        'user_id' => session('user.id'),
        'judul' => 'Bukti Pembayaran Terkirim',
        'pesan' => 'Bukti pembayaran untuk kamar ' . $booking->kamar->nomor_kamar . ' telah dikirim dan sedang menunggu verifikasi.',
        'link' => '/booking-aktif',
        'tipe' => 'payment_submitted',
        'is_read' => true,
    ]);
        
        return redirect('/notif-pembayaran-berhasil')->with('success', 'Bukti pembayaran berhasil diupload');
    }
    
    public function bookingAktif()
    {
        try {
            // Auto-complete expired bookings
            Booking::autoCompleteExpired();

            $penyewaId = session('user.id');
            \Log::debug('bookingAktif START - penyewaId: ' . $penyewaId);
            
            $bookings = Booking::with(['kamar.kos', 'pembayarans'])
                ->where('penyewa_id', $penyewaId)
                ->where('status', 'aktif')
                ->orderBy('created_at', 'desc')
                ->get();
            
            \Log::debug('bookingAktif - bookings count: ' . $bookings->count());
            
            if ($bookings->count() > 0) {
                \Log::debug('bookingAktif - First booking ID: ' . $bookings->first()->id);
            }
            
            return view('penyewa.bookingAktif', compact('bookings'));
        } catch (\Exception $e) {
            \Log::error('Error in bookingAktif: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->view('errors.500', ['exception' => $e], 500);
        }
    }
    
    public function menungguKonfirmasi()
    {
        try {
            $penyewaId = session('user.id');
            
            $bookings = Booking::with(['kamar.kos', 'pembayarans'])
                ->where('penyewa_id', $penyewaId)
                ->where('status', 'menunggu_konfirmasi')
                ->orderBy('created_at', 'desc')
                ->get();
            
            return view('penyewa.bookingMenungguKonfirmasi', compact('bookings'));
        } catch (\Exception $e) {
            \Log::error('Error in menungguKonfirmasi: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data booking.');
        }
    }

    public function menungguPembayaran()
    {
        try {
            $penyewaId = session('user.id');
            
            $bookings = Booking::with(['kamar.kos', 'pembayarans'])
                ->where('penyewa_id', $penyewaId)
                ->whereIn('status', ['menunggu_pembayaran', 'verifikasi_pembayaran'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            return view('penyewa.bookingMenungguPembayaran', compact('bookings'));
        } catch (\Exception $e) {
            \Log::error('Error in menungguPembayaran: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data pembayaran.');
        }
    }
    
    public function riwayatBooking()
    {
        try {
            $penyewaId = session('user.id');
            
            $bookings = Booking::with(['kamar.kos', 'pembayarans'])
                ->where('penyewa_id', $penyewaId)
                ->whereIn('status', ['selesai', 'dibatalkan', 'ditolak'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            return view('penyewa.riwayatBooking', compact('bookings'));
        } catch (\Exception $e) {
            \Log::error('Error in riwayatBooking: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat riwayat booking.');
        }
    }

    public function selesaikanSewa($id)
    {
        $booking = Booking::with(['kamar.kos', 'penyewa'])->where('penyewa_id', session('user.id'))->findOrFail($id);
        
        // Update booking status
        $booking->update(['status' => 'selesai']);
        
        // Update room status to available
        if ($booking->kamar) {
            $booking->kamar->update(['status' => 'tersedia']);
        }

        // Create notification for pemilik
        if ($booking->kamar && $booking->kamar->kos) {
            Notifikasi::create([
                'user_id' => $booking->kamar->kos->pemilik_id,
                'judul' => 'Penyewaan Selesai',
                'pesan' => 'Penyewa ' . ($booking->penyewa->nama_user ?? 'Penyewa') . ' telah menyelesaikan penyewaan kamar ' . ($booking->kamar->nomor_kamar ?? '') . '.',
                'link' => '/pemilik/kelola-pesanan',
                'tipe' => 'rental_finished',
                'is_read' => false,
            ]);
        }

        // Create notification for penyewa
        Notifikasi::create([
            'user_id' => session('user.id'),
            'judul' => 'Penyewaan Selesai',
            'pesan' => 'Anda telah menyelesaikan penyewaan kamar ' . ($booking->kamar->nomor_kamar ?? '') . '. Terima kasih telah menggunakan layanan kami!',
            'link' => '/riwayat-booking',
            'tipe' => 'rental_finished',
            'is_read' => true,
        ]);
        
        return redirect('/riwayat-booking')->with('success', 'Penyewaan telah diselesaikan. Terima kasih telah menyewa di kos ini.');
    }

    public function batalkanBooking($id)
    {
        $booking = Booking::with('kamar')->where('penyewa_id', session('user.id'))->findOrFail($id);
        
        // Only allow cancellation if status is waiting for confirmation or waiting for payment
        if (!in_array($booking->status, ['menunggu_konfirmasi', 'menunggu_pembayaran'])) {
            return back()->with('error', 'Booking tidak dapat dibatalkan pada status saat ini.');
        }

        $oldStatus = $booking->status;
        // Update booking status
        $booking->update(['status' => 'dibatalkan']);
        
        // Update room status to available if it was reserved
        if ($oldStatus == 'menunggu_pembayaran' && $booking->kamar) {
            $booking->kamar->update(['status' => 'tersedia']);
        }
        
        return redirect('/riwayat-booking')->with('success', 'Booking berhasil dibatalkan.');
    }
    
    public function submitKeluhan()
    {
        $penyewaId = session('user.id');
        
        // Get kos from active bookings
        $kosIds = Booking::where('penyewa_id', $penyewaId)
            ->where('status', 'aktif')
            ->with('kamar.kos')
            ->get()
            ->pluck('kamar.kos.id')
            ->unique();
        
        $kosList = Kos::whereIn('id', $kosIds)->get();
        
        return view('penyewa.submitKeluhan', compact('kosList'));
    }
    
    public function storeKeluhan(Request $request)
    {
        $validated = $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'nullable|string|max:100',
            'prioritas' => 'required|string|in:rendah,sedang,tinggi',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:5120', // Allow images and PDF up to 5MB
        ]);
        
        $validated['penyewa_id'] = session('user.id');
        
        // Handle file upload
        if ($request->hasFile('bukti')) {
            try {
                $file = $request->file('bukti');
                if ($file->isValid()) {
                    // Use base64 for Cloudinary upload to avoid path issues
                    $base64 = base64_encode($file->get());
                    $mime = $file->getMimeType();
                    $dataUri = "data:$mime;base64,$base64";
                    
                    $upload = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::uploadApi()->upload($dataUri, [
                        'folder' => 'keluhan'
                    ]);
                    
                    $validated['bukti'] = $upload['secure_url'];
                }
            } catch (\Exception $e) {
                \Log::error('Cloudinary Error (Complaint): ' . $e->getMessage());
                return back()->with('error', 'Gagal mengupload bukti: ' . $e->getMessage())->withInput();
            }
        }
        
        $keluhan = Keluhan::create($validated);
        
        // Create notification for pemilik
        $kos = Kos::find($validated['kos_id']);
        Notifikasi::create([
            'user_id' => $kos->pemilik_id,
            'judul' => 'Keluhan Baru',
            'pesan' => 'Keluhan baru: ' . $validated['judul'] . ' (' . ucfirst($validated['prioritas']) . ')',
            'link' => '/pemilik/keluhan-kos',
            'tipe' => 'new_complaint',
        ]);
        
        return redirect('/submitKeluhan')->with('success', 'Keluhan berhasil disubmit');
    }
    
    public function tulisReview($kosId)
    {
        $kos = Kos::findOrFail($kosId);
        
        // Check if user has active or completed booking for this kos
        $hasBooking = Booking::where('penyewa_id', session('user.id'))
            ->whereHas('kamar', function($query) use ($kosId) {
                $query->where('kos_id', $kosId);
            })
            ->whereIn('status', ['aktif', 'selesai'])
            ->exists();
        
        if (!$hasBooking) {
            return redirect()->back()->with('error', 'Anda harus pernah menyewa di kos ini untuk memberikan review');
        }
        
        return view('penyewa.TulisReview', compact('kos'));
    }
    
    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);
        
        $validated['penyewa_id'] = session('user.id');
        
        // Check if already reviewed
        $exists = Review::where('penyewa_id', $validated['penyewa_id'])
            ->where('kos_id', $validated['kos_id'])
            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk kos ini');
        }
        
        Review::create($validated);
        
        return redirect('/review')->with('success', 'Review berhasil ditambahkan');
    }
    
    public function review()
    {
        $penyewaId = session('user.id');
        
        // Ambil riwayat review
        $reviews = Review::with('kos')
            ->where('penyewa_id', $penyewaId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil daftar kos yang bisa direview (dari booking aktif/selesai)
        // Dan belum pernah direview oleh user ini
        $kosToReview = Booking::where('penyewa_id', $penyewaId)
            ->whereIn('status', ['aktif', 'selesai'])
            ->with(['kamar.kos']) 
            ->get()
            ->pluck('kamar.kos')
            ->filter()
            ->unique('id');
        
        return view('penyewa.review', compact('reviews', 'kosToReview'));
    }
    
    public function notifikasi()
    {
        $userId = session('user.id');
        
        $notifikasis = Notifikasi::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('penyewa.notifikasi', compact('notifikasis'));
    }
    
    public function markNotificationAsRead($id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('user_id', session('user.id'))
            ->firstOrFail();
        
        $notifikasi->markAsRead();
        
        return response()->json(['success' => true]);
    }

    public function editProfile()
    {
         $id= session('user.id');

        $user = data_user_model::find($id);
        
        return view('penyewa.profil', compact('user'));
    }

    public function logoutPenyewa(Request $request)
    {
        // Simple logout - redirect to main login
        session()->flush();
        return redirect('/');
    }

    public function tampilKonfirmasiSewa($id)
    {
        $type = request()->query('type');
        $booking = null;
        $kos = null;
        $kamar = null;

        if ($type === 'booking') {
            $booking = Booking::with('kamar.kos')->find($id);
            if ($booking) {
                $kamar = $booking->kamar ?? null;
                $kos = $kamar->kos ?? null;
            }
        }

        // If not found as booking or type not specified, try finding as Kos
        if (!$kos) {
            $kos = \App\Models\Kos::find($id);
            if ($kos) {
                $availableKamars = Kamar::where('kos_id', $kos->id)
                    ->where('status', 'tersedia')
                    ->get();
                $kamar = $availableKamars->first() ?? null;
            } else {
                // If still not found, try as booking anyway as fallback (legacy behavior)
                $booking = Booking::with('kamar.kos')->find($id);
                if ($booking) {
                    $kamar = $booking->kamar ?? null;
                    $kos = $kamar->kos ?? null;
                }
            }
        }

        if (!$kos) {
            return abort(404, 'Data Kos tidak ditemukan');
        }

        // Fetch available rooms for the selected Kos if not already set (e.g. from booking)
        // or always refresh them to allow switching in the form
        $availableKamars = Kamar::where('kos_id', $kos->id)
            ->where('status', 'tersedia')
            ->get();
        
        // Ensure the current kamar is in the list
        if ($kamar && !$availableKamars->contains('id', $kamar->id)) {
            $availableKamars->push($kamar);
        }
        
        // If AJAX request, return only the modal content
        if (request()->ajax() || request()->wantsJson()) {
            return view('penyewa.partials.konfirmasiSewaContent', compact('kos', 'kamar', 'booking', 'availableKamars'));
        }
        
        // Otherwise return full page
        return view('penyewa.KonfirmasiSewa', compact('kos', 'kamar', 'booking', 'availableKamars'));
    }

    public function pembayaran()
    {
        $penyewaId = session('user.id');
        $pembayarans = Pembayaran::whereHas('booking', function($query) use ($penyewaId) {
            $query->where('penyewa_id', $penyewaId);
        })
        ->with(['booking.kamar.kos'])
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('penyewa.pembayaran', compact('pembayarans'));
    }

    public function perpanjangSewa($bookingId)
    {
        $booking = Booking::with(['kamar.kos', 'penyewa'])
            ->where('id', $bookingId)
            ->where('penyewa_id', session('user.id'))
            ->where('status', 'aktif')
            ->firstOrFail();
        
        return view('penyewa.perpanjangSewa', compact('booking'));
    }

    public function storePerpanjangan(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:booking,id',
            'durasi_bulan' => 'required|integer|min:1|max:12',
        ]);
        
        // Verify booking belongs to penyewa and is active
        $originalBooking = Booking::with('kamar.kos')
            ->where('id', $validated['booking_id'])
            ->where('penyewa_id', session('user.id'))
            ->where('status', 'aktif')
            ->firstOrFail();
        
        // Calculate new dates from current end date
        $tanggalMulai = \Carbon\Carbon::parse($originalBooking->tanggal_selesai)->addDay();
        $tanggalSelesai = $tanggalMulai->copy()->addMonths((int)$validated['durasi_bulan']);
        $totalHarga = $originalBooking->kamar->harga * $validated['durasi_bulan'];
        
        // Create new booking for extension
        $extensionBooking = Booking::create([
            'penyewa_id' => session('user.id'),
            'kamar_id' => $originalBooking->kamar_id,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'durasi_bulan' => $validated['durasi_bulan'],
            'total_harga' => $totalHarga,
            'status' => 'menunggu_pembayaran',
        ]);
        
        // Create notification for pemilik
        Notifikasi::create([
            'user_id' => $originalBooking->kamar->kos->pemilik_id,
            'judul' => 'Perpanjangan Sewa',
            'pesan' => 'Perpanjangan sewa untuk kamar ' . $originalBooking->kamar->nomor_kamar . ' di ' . $originalBooking->kamar->kos->nama_kos,
            'link' => '/pemilik/kelola-pesanan',
            'tipe' => 'extension_request',
        ]);
        
        return redirect('/pembayaran-sewa/' . $extensionBooking->id)
            ->with('success', 'Perpanjangan sewa berhasil dibuat. Silakan lakukan pembayaran.');
    }
}
