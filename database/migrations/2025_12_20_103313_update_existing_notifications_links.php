<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing notifications based on their type
        DB::table('notifikasi')->where('tipe', 'new_booking')->update(['link' => '/pemilik/kelola-pesanan']);
        DB::table('notifikasi')->where('tipe', 'new_payment')->update(['link' => '/pemilik/verifikasi-pembayaran']);
        
        DB::table('notifikasi')->where('tipe', 'booking_confirmed')->update(['link' => '/booking-aktif']);
        DB::table('notifikasi')->where('tipe', 'booking_rejected')->update(['link' => '/riwayat-booking']);
        
        DB::table('notifikasi')->where('tipe', 'payment_verified')->update(['link' => '/booking-aktif']);
        DB::table('notifikasi')->where('tipe', 'payment_rejected')->update(['link' => '/menunggu-pembayaran']);
        
        DB::table('notifikasi')->where('tipe', 'complaint_processing')->update(['link' => '/profil-penyewa']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse data updates strictly, or set them back to null if desired
        DB::table('notifikasi')->update(['link' => null]);
    }
};
