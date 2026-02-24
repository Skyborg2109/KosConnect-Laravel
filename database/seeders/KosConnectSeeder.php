<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\data_user_model;
use App\Models\Kos;
use App\Models\Kamar;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Keluhan;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Hash;

class KosConnectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Users
        $admin = data_user_model::create([
            'nama_user' => 'Administrator',
            'email' => 'admin@kosconnect.com',
            'nomor_telepon' => '081234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $pemilik1 = data_user_model::create([
            'nama_user' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'nomor_telepon' => '081234567891',
            'password' => Hash::make('pemilik123'),
            'role' => 'pemilik',
        ]);

        $pemilik2 = data_user_model::create([
            'nama_user' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'nomor_telepon' => '081234567892',
            'password' => Hash::make('pemilik123'),
            'role' => 'pemilik',
        ]);

        $penyewa1 = data_user_model::create([
            'nama_user' => 'Ahmad Rizki',
            'email' => 'ahmad@gmail.com',
            'nomor_telepon' => '081234567893',
            'password' => Hash::make('penyewa123'),
            'role' => 'penyewa',
        ]);

        $penyewa2 = data_user_model::create([
            'nama_user' => 'Dewi Lestari',
            'email' => 'dewi@gmail.com',
            'nomor_telepon' => '081234567894',
            'password' => Hash::make('penyewa123'),
            'role' => 'penyewa',
        ]);

        // Create Kos
        $kos1 = Kos::create([
            'nama_kos' => 'Capitol Kost',
            'pemilik_id' => $pemilik1->id,
            'alamat' => 'Jl. Sudirman No. 123',
            'kota' => 'Jakarta Pusat',
            'provinsi' => 'DKI Jakarta',
            'harga_dasar' => 765000,
            'deskripsi' => 'Kos nyaman di pusat kota Jakarta dengan fasilitas lengkap',
            'fasilitas' => ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Parkir', 'Dapur Bersama'],
            'peraturan' => ['Tidak boleh membawa hewan peliharaan', 'Jam malam pukul 23:00', 'Dilarang merokok di dalam kamar'],
            'status' => 'aktif',
        ]);

        $kos2 = Kos::create([
            'nama_kos' => 'Riyad Kost',
            'pemilik_id' => $pemilik1->id,
            'alamat' => 'Jl. Thamrin No. 456',
            'kota' => 'Jakarta Selatan',
            'provinsi' => 'DKI Jakarta',
            'harga_dasar' => 850000,
            'deskripsi' => 'Kos eksklusif dengan fasilitas premium',
            'fasilitas' => ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Parkir', 'Laundry', 'Gym'],
            'peraturan' => ['Tidak boleh membawa hewan peliharaan', 'Jam malam pukul 24:00'],
            'status' => 'aktif',
        ]);

        $kos3 = Kos::create([
            'nama_kos' => 'Green Valley Kost',
            'pemilik_id' => $pemilik2->id,
            'alamat' => 'Jl. Gatot Subroto No. 789',
            'kota' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'harga_dasar' => 650000,
            'deskripsi' => 'Kos asri dengan suasana sejuk khas Bandung',
            'fasilitas' => ['WiFi', 'Kamar Mandi Dalam', 'Parkir', 'Taman'],
            'peraturan' => ['Tidak boleh membawa hewan peliharaan', 'Jam malam pukul 22:00'],
            'status' => 'aktif',
        ]);

        // Create Kamar for Capitol Kost
        $kamar1 = Kamar::create([
            'kos_id' => $kos1->id,
            'nomor_kamar' => '5A',
            'tipe_kamar' => 'Standard',
            'harga' => 765000,
            'luas' => 12,
            'fasilitas' => ['Kasur', 'Lemari', 'Meja Belajar', 'AC'],
            'status' => 'tersedia',
        ]);

        $kamar2 = Kamar::create([
            'kos_id' => $kos1->id,
            'nomor_kamar' => '5B',
            'tipe_kamar' => 'Standard',
            'harga' => 765000,
            'luas' => 12,
            'fasilitas' => ['Kasur', 'Lemari', 'Meja Belajar', 'AC'],
            'status' => 'terisi',
        ]);

        // Create Kamar for Riyad Kost
        $kamar3 = Kamar::create([
            'kos_id' => $kos2->id,
            'nomor_kamar' => '3A',
            'tipe_kamar' => 'Deluxe',
            'harga' => 850000,
            'luas' => 15,
            'fasilitas' => ['Kasur Queen', 'Lemari', 'Meja Belajar', 'AC', 'TV'],
            'status' => 'tersedia',
        ]);

        $kamar4 = Kamar::create([
            'kos_id' => $kos2->id,
            'nomor_kamar' => '3B',
            'tipe_kamar' => 'Deluxe',
            'harga' => 850000,
            'luas' => 15,
            'fasilitas' => ['Kasur Queen', 'Lemari', 'Meja Belajar', 'AC', 'TV'],
            'status' => 'tersedia',
        ]);

        // Create Kamar for Green Valley Kost
        $kamar5 = Kamar::create([
            'kos_id' => $kos3->id,
            'nomor_kamar' => '2A',
            'tipe_kamar' => 'Standard',
            'harga' => 650000,
            'luas' => 10,
            'fasilitas' => ['Kasur', 'Lemari', 'Meja Belajar'],
            'status' => 'tersedia',
        ]);

        // Create Bookings
        $booking1 = Booking::create([
            'penyewa_id' => $penyewa1->id,
            'kamar_id' => $kamar2->id,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(6),
            'durasi_bulan' => 6,
            'total_harga' => 765000 * 6,
            'status' => 'aktif',
        ]);

        $booking2 = Booking::create([
            'penyewa_id' => $penyewa2->id,
            'kamar_id' => $kamar1->id,
            'tanggal_mulai' => now()->addDays(7),
            'tanggal_selesai' => now()->addMonths(3)->addDays(7),
            'durasi_bulan' => 3,
            'total_harga' => 765000 * 3,
            'status' => 'menunggu_konfirmasi',
        ]);

        // Create Pembayaran
        $pembayaran1 = Pembayaran::create([
            'booking_id' => $booking1->id,
            'jumlah' => 765000 * 6,
            'metode_pembayaran' => 'Transfer Bank',
            'tanggal_bayar' => now(),
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => $pemilik1->id,
        ]);

        $pembayaran2 = Pembayaran::create([
            'booking_id' => $booking2->id,
            'jumlah' => 765000 * 3,
            'metode_pembayaran' => 'Transfer Bank',
            'tanggal_bayar' => now(),
            'status' => 'pending',
        ]);

        // Create Keluhan
        $keluhan1 = Keluhan::create([
            'penyewa_id' => $penyewa1->id,
            'kos_id' => $kos1->id,
            'judul' => 'AC Kamar Tidak Dingin',
            'deskripsi' => 'AC di kamar 5B tidak dingin, mohon segera diperbaiki',
            'kategori' => 'Fasilitas',
            'status' => 'diproses',
        ]);

        $keluhan2 = Keluhan::create([
            'penyewa_id' => $penyewa1->id,
            'kos_id' => $kos1->id,
            'judul' => 'WiFi Lambat',
            'deskripsi' => 'Koneksi WiFi sangat lambat, sulit untuk bekerja',
            'kategori' => 'Internet',
            'status' => 'pending',
        ]);

        // Create Reviews
        $review1 = Review::create([
            'penyewa_id' => $penyewa1->id,
            'kos_id' => $kos1->id,
            'rating' => 4,
            'komentar' => 'Kos nyaman dan bersih, lokasi strategis. Hanya perlu perbaikan AC.',
        ]);

        // Create Wishlist
        $wishlist1 = Wishlist::create([
            'penyewa_id' => $penyewa2->id,
            'kos_id' => $kos2->id,
        ]);

        $wishlist2 = Wishlist::create([
            'penyewa_id' => $penyewa2->id,
            'kos_id' => $kos3->id,
        ]);

        // Create Notifikasi
        Notifikasi::create([
            'user_id' => $pemilik1->id,
            'judul' => 'Booking Baru',
            'pesan' => 'Ada booking baru untuk kamar 5A di Capitol Kost',
            'tipe' => 'new_booking',
            'is_read' => false,
        ]);

        Notifikasi::create([
            'user_id' => $pemilik1->id,
            'judul' => 'Keluhan Baru',
            'pesan' => 'Ada keluhan baru: AC Kamar Tidak Dingin',
            'tipe' => 'new_complaint',
            'is_read' => false,
        ]);

        Notifikasi::create([
            'user_id' => $penyewa1->id,
            'judul' => 'Pembayaran Diverifikasi',
            'pesan' => 'Pembayaran Anda sebesar Rp 4.590.000 telah diverifikasi',
            'tipe' => 'payment_verified',
            'is_read' => true,
        ]);

        Notifikasi::create([
            'user_id' => $penyewa2->id,
            'judul' => 'Menunggu Verifikasi',
            'pesan' => 'Pembayaran Anda menunggu verifikasi dari pemilik kos',
            'tipe' => 'payment_pending',
            'is_read' => false,
        ]);
    }
}
