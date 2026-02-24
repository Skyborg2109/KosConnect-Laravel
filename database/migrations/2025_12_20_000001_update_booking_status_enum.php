<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Using raw statement because changing ENUM via Doctrine/Schema builder can be tricky with custom types
        DB::statement("ALTER TABLE booking MODIFY COLUMN status ENUM('menunggu_konfirmasi', 'menunggu_pembayaran', 'verifikasi_pembayaran', 'aktif', 'selesai', 'dibatalkan', 'ditolak') DEFAULT 'menunggu_konfirmasi'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum definition
        DB::statement("ALTER TABLE booking MODIFY COLUMN status ENUM('menunggu_konfirmasi', 'aktif', 'selesai', 'dibatalkan') DEFAULT 'menunggu_konfirmasi'");
    }
};
