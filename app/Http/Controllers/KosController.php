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
use App\Models\KosImage;
use App\Models\KamarImage;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class KosController extends Controller
{
    // ============ ADMIN METHODS ============
    
    public function adminTransaksi()
    {
        $bookings = Booking::with(['penyewa', 'kamar.kos', 'pembayarans'])
            ->where('status', 'menunggu_pembayaran')
            ->orWhere('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingPayments = Pembayaran::with(['booking.penyewa', 'booking.kamar.kos'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.admin_transaksi', compact('bookings', 'pendingPayments'));
    }

    public function adminVerifikasiPembayaran($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => 1, // Admin ID assumption or auth()->id() if admin login uses same table
        ]);
        
        // Update status booking menjadi aktif
        $pembayaran->booking->update(['status' => 'aktif']);

        // Create notification for penyewa
        Notifikasi::create([
            'user_id' => $pembayaran->booking->penyewa_id,
            'judul' => 'Pembayaran Diverifikasi Admin',
            'pesan' => 'Pembayaran Anda sebesar Rp ' . number_format($pembayaran->jumlah, 0, ',', '.') . ' telah diverifikasi oleh Admin',
            'link' => '/booking-aktif',
            'tipe' => 'payment_verified',
        ]);
        
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi oleh Admin');
    }

    public function adminTolakPembayaran($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $pembayaran->update(['status' => 'rejected']);
        
        // Update status booking kembali menjadi menunggu_pembayaran agar bisa upload ulang
        $pembayaran->booking->update(['status' => 'menunggu_pembayaran']);
        
        // Create notification for penyewa
        Notifikasi::create([
            'user_id' => $pembayaran->booking->penyewa_id,
            'judul' => 'Pembayaran Ditolak Admin',
            'pesan' => 'Pembayaran Anda ditolak oleh Admin. Silakan upload ulang bukti pembayaran yang valid',
            'link' => '/menunggu-pembayaran',
            'tipe' => 'payment_rejected',
        ]);
        
        return redirect()->back()->with('success', 'Pembayaran ditolak oleh Admin');
    }
    
    public function adminKeluhan()
    {
        $keluhans = Keluhan::with(['penyewa', 'kos'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.admin_keluhan', compact('keluhans'));
    }
    
    public function adminLaporan()
    {
        $totalKos = Kos::count();
        $totalBooking = Booking::count();
        $totalPendapatan = Pembayaran::where('status', 'verified')->sum('jumlah');
        $totalKeluhan = Keluhan::count();
        
        $periode = request('periode', 6);
        $jenisData = request('jenis_data', 'booking');
        
        $query = Booking::selectRaw('
                MONTH(created_at) as bulan, 
                YEAR(created_at) as tahun, 
                COUNT(*) as total,
                SUM(CASE WHEN status = "aktif" THEN 1 ELSE 0 END) as sukses
            ')
            ->where('created_at', '>=', now()->subMonths((int)$periode));

        if ($jenisData == 'pembayaran') {
             $query = Pembayaran::selectRaw('
                MONTH(created_at) as bulan, 
                YEAR(created_at) as tahun, 
                COUNT(*) as total,
                SUM(CASE WHEN status = "verified" THEN 1 ELSE 0 END) as sukses,
                SUM(CASE WHEN status = "verified" THEN jumlah ELSE 0 END) as pendapatan
            ')
            ->where('created_at', '>=', now()->subMonths((int)$periode));
            
             $bookingPerBulan = $query->groupBy('tahun', 'bulan')
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
        } else {
            $bookingPerBulan = $query->groupBy('tahun', 'bulan')
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
        }
            
        return view('admin.admin_laporan', compact('totalKos', 'totalBooking', 'totalPendapatan', 'totalKeluhan', 'bookingPerBulan'));
    }

    public function exportLaporan(Request $request)
    {
        $periode = $request->input('periode', 6);
        $jenisData = $request->input('jenis_data', 'booking');
        
        $fileName = 'laporan_' . $jenisData . '_' . date('Y-m-d_H-i-s') . '.csv';
        
        if ($jenisData == 'pembayaran') {
             $data = Pembayaran::selectRaw('
                MONTH(created_at) as bulan, 
                YEAR(created_at) as tahun, 
                COUNT(*) as total,
                SUM(CASE WHEN status = "verified" THEN 1 ELSE 0 END) as sukses,
                 SUM(CASE WHEN status = "verified" THEN jumlah ELSE 0 END) as pendapatan
            ')
            ->where('created_at', '>=', now()->subMonths((int)$periode))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();
            
            $columns = array('Bulan', 'Tahun', 'Total Transaksi', 'Transaksi Sukses', 'Total Pendapatan');
        } else {
            $data = Booking::selectRaw('
                    MONTH(created_at) as bulan, 
                    YEAR(created_at) as tahun, 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = "aktif" THEN 1 ELSE 0 END) as sukses
                ')
                ->where('created_at', '>=', now()->subMonths((int)$periode))
                ->groupBy('tahun', 'bulan')
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->get();
                
            $columns = array('Bulan', 'Tahun', 'Total Transaksi', 'Sukses', 'Persentase Sukses');
        }

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $callback = function() use($data, $columns, $jenisData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $row) {
                if ($jenisData == 'pembayaran') {
                     fputcsv($file, array(
                        \Carbon\Carbon::createFromDate($row->tahun, $row->bulan, 1)->translatedFormat('F'),
                        $row->tahun,
                        $row->total,
                        $row->sukses,
                        'Rp ' . number_format($row->pendapatan, 0, ',', '.')
                    ));
                } else {
                    $percentage = $row->total > 0 ? round(($row->sukses / $row->total * 100)) . '%' : '0%';
                    fputcsv($file, array(
                        \Carbon\Carbon::createFromDate($row->tahun, $row->bulan, 1)->translatedFormat('F'),
                        $row->tahun,
                        $row->total,
                        $row->sukses,
                        $percentage
                    ));
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    
    public function deleteKos($id)
    {
        $kos = Kos::findOrFail($id);
        
        // Delete associated image if exists
        if ($kos->gambar && Storage::exists('public/' . $kos->gambar)) {
            Storage::delete('public/' . $kos->gambar);
        }
        
        $kos->delete();
        
        return redirect()->back()->with('success', 'Kos berhasil dihapus');
    }
    
    // ============ PEMILIK METHODS ============
    
    public function pemilikManajemenKos()
    {
        $pemilikId = session('user.id');
        $kos = Kos::where('pemilik_id', $pemilikId)
            ->with('kamar')
            ->get();
            
        return view('pemilik.manajemen_kos', compact('kos'));
    }
    
    public function tambahKos(Request $request)
    {
        $validated = $request->validate([
            'nama_kos' => 'required|string|max:255',
            'jenis_kos' => 'required|in:campuran,putra,putri',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'harga_dasar' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'fasilitas' => 'nullable|array',
            'peraturan' => 'nullable|array',
            'gambar' => 'nullable', // Generic
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            // Categorized images validation
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_bangunan' => 'nullable',
            'gambar_bangunan.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'gambar_fasilitas' => 'nullable',
            'gambar_fasilitas.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'gambar_kamar' => 'nullable',
            'gambar_kamar.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'gambar_kamar_mandi' => 'nullable',
            'gambar_kamar_mandi.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'gambar_lainnya' => 'nullable',
            'gambar_lainnya.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $validated['pemilik_id'] = session('user.id');
        
        // Remove file inputs from validated data to prevent MassAssignmentException
        $kosData = collect($validated)->except([
            'gambar', 'gambar_utama', 'gambar_bangunan', 'gambar_fasilitas', 
            'gambar_kamar', 'gambar_kamar_mandi', 'gambar_lainnya'
        ])->toArray();
        
        $kos = Kos::create($kosData);
        
        // Helper function to upload and save images
        $processImages = function($files, $type) use ($kos) {
            if (!$files) return;
            if (!is_array($files)) $files = [$files];
            
            foreach ($files as $index => $file) {
                 if ($file->isValid()) {
                    try {
                        $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode($file->get());
                        $result = Cloudinary::uploadApi()->upload($base64, ['folder' => 'kos']);
                        $url = $result['secure_url'];
                        
                        KosImage::create([
                            'kos_id' => $kos->id,
                            'image_url' => $url,
                            'jenis_foto' => $type,
                            'order' => $index
                        ]);
                        
                        // If type is 'utama', set as main thumbnail
                        if ($type === 'utama') {
                            $kos->update(['gambar' => $url]);
                        }
                    } catch (\Exception $e) {
                         \Illuminate\Support\Facades\Log::error("Cloudinary upload failed ($type): " . $e->getMessage());
                    }
                }
            }
        };

        // Process Categorized Images
        if ($request->hasFile('gambar_utama')) $processImages($request->file('gambar_utama'), 'utama');
        if ($request->hasFile('gambar_bangunan')) $processImages($request->file('gambar_bangunan'), 'bangunan');
        if ($request->hasFile('gambar_fasilitas')) $processImages($request->file('gambar_fasilitas'), 'fasilitas');
        if ($request->hasFile('gambar_kamar')) $processImages($request->file('gambar_kamar'), 'kamar');
        if ($request->hasFile('gambar_kamar_mandi')) $processImages($request->file('gambar_kamar_mandi'), 'kamar_mandi');
        if ($request->hasFile('gambar_lainnya')) $processImages($request->file('gambar_lainnya'), 'lainnya');
        
        // Backward compatibility for generic 'gambar' input (treat as 'lainnya' or 'utama'?)
        // If 'gambar_utama' wasn't provided but generic 'gambar' was, maybe use first as utama?
        if ($request->hasFile('gambar')) {
             // If we haven't set a thumbnail yet, let's treat the first generic image as potential thumbnail
             $files = $request->file('gambar');
             if (!is_array($files)) $files = [$files];
             
             foreach ($files as $index => $file) {
                  // We'll save them as 'lainnya' generically, unless we want to guess.
                  // But check if we need to set main image
                  if ($index === 0 && !$kos->gambar) {
                       // Upload and set as generic types but update main thumbnail
                       // Re-use logic: passing 'lainnya' but manually updating kos->gambar inside loop? 
                       // Simplify: just pass to processImages with 'lainnya'.
                       // But wait, processImages('lainnya') won't update kos->gambar unless type is 'utama'.
                       // So we manually handle thumbnail update if needed.
                  }
                  // Let's just process as 'lainnya'. If user uses old form, they get 'lainnya' type.
             }
             $processImages($request->file('gambar'), 'lainnya');
             
             // Initial thumbnail fallback
             if (!$kos->gambar && $request->hasFile('gambar')) {
                 $firstImage = KosImage::where('kos_id', $kos->id)->first();
                 if ($firstImage) $kos->update(['gambar' => $firstImage->image_url]);
             }
        }
        
        // Create notification for admin
        Notifikasi::create([
            'user_id' => 1, // Admin ID
            'judul' => 'Kos Baru Ditambahkan',
            'pesan' => 'Kos baru "' . $validated['nama_kos'] . '" telah ditambahkan',
            'tipe' => 'kos_baru',
            'link' => '/data-kos',
        ]);
        
        return redirect('/pemilik/manajemen-kos')->with('success', 'Kos berhasil ditambahkan!');
    }
    
    public function pemilikEditKos($id)
    {
        $kos = Kos::where('id', $id)
            ->where('pemilik_id', session('user.id'))
            ->firstOrFail();
            
        return view('pemilik.edit_kos', compact('kos'));
    }
    
    public function pemilikUpdateKos(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:kos,id',
            'nama_kos' => 'required|string|max:255',
            'jenis_kos' => 'required|in:campuran,putra,putri',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'harga_dasar' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'fasilitas' => 'nullable|array',
            'peraturan' => 'nullable|array',
            'gambar' => 'nullable',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_bangunan' => 'nullable',
            'gambar_bangunan.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'gambar_fasilitas' => 'nullable',
            'gambar_fasilitas.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'gambar_kamar' => 'nullable',
            'gambar_kamar.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'gambar_kamar_mandi' => 'nullable',
            'gambar_kamar_mandi.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'gambar_lainnya' => 'nullable',
            'gambar_lainnya.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'nullable|in:aktif,nonaktif',
        ]);
        
        $kos = Kos::where('id', $validated['id'])
            ->where('pemilik_id', session('user.id'))
            ->firstOrFail();
            
        // Helper function to upload and save images
        $processImages = function($files, $type) use ($kos) {
            if (!$files) return;
            if (!is_array($files)) $files = [$files];
            
            foreach ($files as $index => $file) {
                 if ($file->isValid()) {
                    try {
                        $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode($file->get());
                        $result = Cloudinary::uploadApi()->upload($base64, ['folder' => 'kos']);
                        $url = $result['secure_url'];
                        
                        KosImage::create([
                            'kos_id' => $kos->id,
                            'image_url' => $url,
                            'jenis_foto' => $type,
                            'order' => 0
                        ]);
                        
                        if ($type === 'utama') {
                            $kos->update(['gambar' => $url]);
                             // Optional: cleanup old
                            if ($kos->getOriginal('gambar') && !str_starts_with($kos->getOriginal('gambar'), 'http') && Storage::disk('public')->exists($kos->getOriginal('gambar'))) {
                                Storage::disk('public')->delete($kos->getOriginal('gambar'));
                            }
                        }
                    } catch (\Exception $e) {
                         \Illuminate\Support\Facades\Log::error("Cloudinary update failed ($type): " . $e->getMessage());
                    }
                }
            }
        };

        // Process Categorized Images
        if ($request->hasFile('gambar_utama')) $processImages($request->file('gambar_utama'), 'utama');
        if ($request->hasFile('gambar_bangunan')) $processImages($request->file('gambar_bangunan'), 'bangunan');
        if ($request->hasFile('gambar_fasilitas')) $processImages($request->file('gambar_fasilitas'), 'fasilitas');
        if ($request->hasFile('gambar_kamar')) $processImages($request->file('gambar_kamar'), 'kamar');
        if ($request->hasFile('gambar_kamar_mandi')) $processImages($request->file('gambar_kamar_mandi'), 'kamar_mandi');
        if ($request->hasFile('gambar_lainnya')) $processImages($request->file('gambar_lainnya'), 'lainnya');
        
        // Handle legacy generic image upload
        if ($request->hasFile('gambar')) {
             $processImages($request->file('gambar'), 'lainnya');
             // If utama is still empty? Rare case in edit.
        } else {
             // If no new image, unset generic 'gambar' from validation so it ignores it
             unset($validated['gambar']);
        }
        
        // Remove file inputs from validation keys to update other fields cleanly
        $updateData = collect($validated)->except([
            'gambar', 'gambar_utama', 'gambar_bangunan', 'gambar_fasilitas', 
            'gambar_kamar', 'gambar_kamar_mandi', 'gambar_lainnya'
        ])->toArray();
        
        $kos->update($updateData);
        
        return redirect('/pemilik/manajemen-kos')->with('success', 'Kos berhasil diupdate!');
    }
    
    public function pemilikManajemenKamar($kosId)
    {
        $kos = Kos::where('id', $kosId)
            ->where('pemilik_id', session('user.id'))
            ->with('kamar')
            ->firstOrFail();
            
        return view('pemilik.manajemen_kamar', [
        'kos' => $kos,
        'kamar' => $kos->kamar
    ]);
    }
    
    public function tambahKamar(Request $request)
    {
        $validated = $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'nomor_kamar' => 'required|string|max:50',
            'tipe_kamar' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'luas' => 'nullable|integer|min:0',
            'fasilitas' => 'nullable|array',
            'gambar' => 'nullable',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Verify kos belongs to pemilik
        $kos = Kos::where('id', $validated['kos_id'])
            ->where('pemilik_id', session('user.id'))
            ->firstOrFail();
        
        // Remove gambar from validated data
        $kamarData = $validated;
        unset($kamarData['gambar']);
        
        $kamar = Kamar::create($kamarData);
        
        // Handle image upload
        if ($request->hasFile('gambar')) {
            $files = $request->file('gambar');
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $index => $file) {
                if ($file->isValid()) {
                    try {
                        $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode($file->get());
                        $result = Cloudinary::uploadApi()->upload($base64, ['folder' => 'kamar']);
                        $url = $result['secure_url'];
                        
                        // Save to KamarImage table
                        KamarImage::create([
                            'kamar_id' => $kamar->id,
                            'image_url' => $url,
                            'order' => $index
                        ]);
                        
                        // If it's the first image, set it as the main thumbnail
                        if ($index === 0) {
                            $kamar->update(['gambar' => $url]);
                        }
                    } catch (\Exception $e) {
                         \Illuminate\Support\Facades\Log::error('Cloudinary upload failed (kamar): ' . $e->getMessage());
                    }
                }
            }
        }
        
        return redirect('/pemilik/manajemen-kamar/' . $validated['kos_id'])->with('success', 'Kamar berhasil ditambahkan!');
    }
    

    
    public function pemilikUpdateKamar(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:kamar,id',
            'nomor_kamar' => 'required|string|max:50',
            'tipe_kamar' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'luas' => 'nullable|integer|min:0',
            'luas' => 'nullable|integer|min:0',
            'fasilitas' => 'nullable|array',
            'status' => 'nullable|in:tersedia,terisi,maintenance',
            'gambar' => 'nullable',
            'gambar.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $kamar = Kamar::whereHas('kos', function($query) {
                $query->where('pemilik_id', session('user.id'));
            })
            ->findOrFail($validated['id']);
        
        // Handle image upload
        if ($request->hasFile('gambar')) {
             $files = $request->file('gambar');
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $index => $file) {
                 if ($file->isValid()) {
                    try {
                        $base64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode($file->get());
                        $result = Cloudinary::uploadApi()->upload($base64, ['folder' => 'kamar']);
                        $url = $result['secure_url'];
                        
                         // Save to KamarImage table
                        KamarImage::create([
                            'kamar_id' => $kamar->id,
                            'image_url' => $url,
                            'order' => 0
                        ]);

                        if ($index === 0) {
                            $validated['gambar'] = $url;
                            
                             if ($kamar->gambar && !str_starts_with($kamar->gambar, 'http') && Storage::disk('public')->exists($kamar->gambar)) {
                                Storage::disk('public')->delete($kamar->gambar);
                            }
                        }
                    } catch (\Exception $e) {
                         \Illuminate\Support\Facades\Log::error('Cloudinary update failed (kamar): ' . $e->getMessage());
                    }
                }
            }
        } else {
             unset($validated['gambar']);
        }
        
        $kamar->update($validated);
        
        return redirect('/pemilik/manajemen-kamar/' . $kamar->kos_id)->with('success', 'Kamar berhasil diupdate!');
    }
    
    public function pemilikKelolaPesanan(Request $request)
    {
        $pemilikId = session('user.id');
        $filter = $request->query('filter', 'semua');
        
        $query = Booking::with(['penyewa', 'kamar.kos'])
            ->whereHas('kamar.kos', function($q) use ($pemilikId) {
                $q->where('pemilik_id', $pemilikId);
            });
            
        // EXCLUDE STATUS verifikasi_pembayaran because it's handled in its own page
        $query->where('status', '!=', 'verifikasi_pembayaran');
            
        // Apply filter
        switch ($filter) {
            case 'baru':
                $query->where('status', 'menunggu_konfirmasi');
                break;
            case 'dikonfirmasi':
                $query->where('status', 'menunggu_pembayaran');
                break;
            case 'dibayar':
                $query->where('status', 'aktif'); // Assuming 'aktif' means paid and valid
                break;
            case 'ditolak':
                $query->where('status', 'ditolak');
                break;
            case 'dibatalkan':
                $query->where('status', 'dibatalkan');
                break;
        }
            
        $bookings = $query->orderBy('created_at', 'desc')->get();
            
        return view('pemilik.kelola_pesanan', compact('bookings', 'filter'));
    }
    
    public function konfirmasiPesanan($id)
    {
        $booking = Booking::whereHas('kamar.kos', function($query) {
                $query->where('pemilik_id', session('user.id'));
            })
            ->findOrFail($id);
        
        $booking->update(['status' => 'menunggu_pembayaran']);
        
        // Update kamar status
        $booking->kamar->update(['status' => 'terisi']);
        
        // Create notification for penyewa
    Notifikasi::create([
        'user_id' => $booking->penyewa_id,
        'judul' => 'Booking Dikonfirmasi',
        'pesan' => 'Booking Anda untuk kamar ' . $booking->kamar->nomor_kamar . ' telah dikonfirmasi',
        'link' => '/menunggu-pembayaran',
        'tipe' => 'booking_confirmed',
    ]);

    // Create notification for pemilik (to show in recent activities)
    Notifikasi::create([
        'user_id' => session('user.id'),
        'judul' => 'Pesanan Dikonfirmasi',
        'pesan' => 'Anda telah mengonfirmasi pesanan dari ' . ($booking->penyewa->nama_user ?? 'Penyewa') . ' untuk kamar ' . $booking->kamar->nomor_kamar,
        'link' => '/pemilik/kelola-pesanan',
        'tipe' => 'booking_confirmed',
    ]);
        
        return redirect('/pemilik/kelola-pesanan')->with('success', 'Pesanan berhasil dikonfirmasi');
    }

    public function tolakPesanan($id)
    {
        $booking = Booking::whereHas('kamar.kos', function($query) {
                $query->where('pemilik_id', session('user.id'));
            })
            ->findOrFail($id);
        
        $booking->update(['status' => 'ditolak']);
        
        // Update kamar status back to available if needed, or keep it as is if it wasn't reserved yet
        // Usually dependent on business logic, but for now assuming we just reject the booking request.
        
        // Create notification for penyewa
    Notifikasi::create([
        'user_id' => $booking->penyewa_id,
        'judul' => 'Booking Ditolak',
        'pesan' => 'Maaf, booking Anda untuk kamar ' . $booking->kamar->nomor_kamar . ' ditolak oleh pemilik.',
        'link' => '/riwayat-booking',
        'tipe' => 'booking_rejected',
    ]);

    // Create notification for pemilik
    Notifikasi::create([
        'user_id' => session('user.id'),
        'judul' => 'Pesanan Ditolak',
        'pesan' => 'Anda telah menolak pesanan dari ' . ($booking->penyewa->nama_user ?? 'Penyewa') . ' untuk kamar ' . $booking->kamar->nomor_kamar,
        'link' => '/pemilik/kelola-pesanan',
        'tipe' => 'booking_rejected',
    ]);
        
        return redirect('/pemilik/kelola-pesanan')->with('success', 'Pesanan telah ditolak');
    }
    
    public function pemilikVerifikasiPembayaran()
    {
        $pemilikId = session('user.id');
        
        $pembayarans = Pembayaran::with(['booking.penyewa', 'booking.kamar.kos'])
            ->whereHas('booking.kamar.kos', function($query) use ($pemilikId) {
                $query->where('pemilik_id', $pemilikId);
            })
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('pemilik.verifikasi_pembayaran', compact('pembayarans'));
    }
    
    public function verifikasiPembayaran($id)
    {
        $pembayaran = Pembayaran::whereHas('booking.kamar.kos', function($query) {
                $query->where('pemilik_id', session('user.id'));
            })
            ->findOrFail($id);
        
        $pembayaran->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => session('user.id'),
        ]);
        
        // Update status booking menjadi aktif
        $pembayaran->booking->update(['status' => 'aktif']);

        // Create notification for penyewa
    Notifikasi::create([
        'user_id' => $pembayaran->booking->penyewa_id,
        'judul' => 'Pembayaran Diverifikasi',
        'pesan' => 'Pembayaran Anda sebesar Rp ' . number_format($pembayaran->jumlah, 0, ',', '.') . ' telah diverifikasi',
        'link' => '/booking-aktif',
        'tipe' => 'payment_verified',
    ]);

    // Create notification for pemilik
    Notifikasi::create([
        'user_id' => session('user.id'),
        'judul' => 'Pembayaran Diverifikasi',
        'pesan' => 'Anda telah memverifikasi pembayaran dari ' . ($pembayaran->booking->penyewa->nama_user ?? 'Penyewa') . ' sebesar Rp ' . number_format($pembayaran->jumlah, 0, ',', '.'),
        'link' => '/pemilik/verifikasi-pembayaran',
        'tipe' => 'payment_verified',
    ]);
        
        return redirect('/pemilik/verifikasi-pembayaran')->with('success', 'Pembayaran berhasil diverifikasi');
    }
    
    public function tolakPembayaran($id)
    {
        $pembayaran = Pembayaran::whereHas('booking.kamar.kos', function($query) {
                $query->where('pemilik_id', session('user.id'));
            })
            ->findOrFail($id);
        
        $pembayaran->update(['status' => 'rejected']);
        
        // Update status booking kembali menjadi menunggu_pembayaran agar bisa upload ulang
        $pembayaran->booking->update(['status' => 'menunggu_pembayaran']);
        
        // Create notification for penyewa
        Notifikasi::create([
            'user_id' => $pembayaran->booking->penyewa_id,
            'judul' => 'Pembayaran Ditolak',
            'pesan' => 'Pembayaran Anda ditolak. Silakan upload ulang bukti pembayaran yang valid',
            'link' => '/menunggu-pembayaran',
            'tipe' => 'payment_rejected',
        ]);
        
        return redirect('/pemilik/verifikasi-pembayaran')->with('success', 'Pembayaran ditolak');
    }
    
    public function pemilikKeluhanKos()
    {
        $pemilikId = session('user.id');
        
        $keluhans = Keluhan::with(['penyewa', 'kos'])
            ->whereHas('kos', function($query) use ($pemilikId) {
                $query->where('pemilik_id', $pemilikId);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('pemilik.keluhan_kos', compact('keluhans'));
    }
    
    public function setKeluhanDiproses($id)
    {
        $keluhan = Keluhan::whereHas('kos', function($query) {
                $query->where('pemilik_id', session('user.id'));
            })
            ->findOrFail($id);
        
        $keluhan->update(['status' => 'diproses']);
        
        // Create notification for penyewa
        Notifikasi::create([
            'user_id' => $keluhan->penyewa_id,
            'judul' => 'Keluhan Sedang Diproses',
            'pesan' => 'Keluhan Anda "' . $keluhan->judul . '" sedang diproses',
            'link' => '/submitKeluhan', // Redirect to complaint page
            'tipe' => 'complaint_processing',
        ]);
        
        return redirect('/pemilik/keluhan-kos')->with('success', 'Status keluhan diupdate menjadi diproses');
    }
    
    public function tandaKeluhanSelesai($id)
    {
        $keluhan = Keluhan::whereHas('kos', function($query) {
                $query->where('pemilik_id', session('user.id'));
            })
            ->findOrFail($id);
        
        $keluhan->update([
            'status' => 'selesai',
            'tanggal_selesai' => now(),
        ]);
        
        // Create notification for penyewa
        Notifikasi::create([
            'user_id' => $keluhan->penyewa_id,
            'judul' => 'Keluhan Selesai',
            'pesan' => 'Keluhan Anda "' . $keluhan->judul . '" telah diselesaikan',
            'tipe' => 'complaint_resolved',
            'link' => '/submitKeluhan',
        ]);
        
        return redirect('/pemilik/keluhan-kos')->with('success', 'Keluhan ditandai selesai');
    }
    
    public function lihatBukti($id)
    {
        $pembayaran = Pembayaran::with(['booking.penyewa', 'booking.kamar.kos'])
            ->whereHas('booking.kamar.kos', function($query) {
                $query->where('pemilik_id', session('user.id'));
            })
            ->findOrFail($id);
            
        return view('pemilik.lihat_bukti', compact('pembayaran'));
    }

    public function logoutAdmin(Request $request)
    {
        session()->flush();
        return redirect('/login-admin');
    }

    // ============ PENYEWA FEEDBACK METHODS ============

    public function showFeedback()
    {
        // Try multiple ways to get the user ID
        $penyewaId = session('id') ?? session('user_id') ?? auth()->id();
        
        if (!$penyewaId) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Get feedback history for this tenant
        $feedbackHistory = Keluhan::where('penyewa_id', $penyewaId)
            ->whereNull('kos_id') // Feedback aplikasi tidak terkait kos tertentu
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('penyewa.feedback', compact('feedbackHistory'));
    }

    public function submitFeedback(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:lapor_bug,permintaan_fitur,lainnya',
            'pesan' => 'required|string|min:10|max:1000',
        ]);

        // Try multiple ways to get the user ID
        $penyewaId = session('id') ?? session('user_id') ?? auth()->id();
        
        if (!$penyewaId) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Map kategori to judul
        $judulMap = [
            'lapor_bug' => 'Lapor Bug',
            'permintaan_fitur' => 'Permintaan Fitur',
            'lainnya' => 'Lainnya',
        ];

        Keluhan::create([
            'penyewa_id' => $penyewaId,
            'kos_id' => null, // Feedback aplikasi
            'judul' => $judulMap[$request->kategori],
            'deskripsi' => $request->pesan,
            'kategori' => $request->kategori,
            'prioritas' => 'sedang',
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Feedback berhasil dikirim! Terima kasih atas masukan Anda.');
    }
}
