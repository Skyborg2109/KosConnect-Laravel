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
        if (Schema::hasTable('booking') && Schema::hasColumn('booking', 'status')) {
            try {
                Schema::table('booking', function (Blueprint $table) {
                    $table->enum('status', [
                        'menunggu_konfirmasi', 
                        'menunggu_pembayaran', 
                        'verifikasi_pembayaran', 
                        'aktif', 
                        'selesai', 
                        'dibatalkan', 
                        'ditolak'
                    ])->default('menunggu_konfirmasi')->change();
                });
            } catch (\Exception $e) {
                // If native change fails (e.g. older MySQL or driver issues), fallback to raw SQL
                try {
                    DB::statement("ALTER TABLE booking MODIFY COLUMN status ENUM('menunggu_konfirmasi', 'menunggu_pembayaran', 'verifikasi_pembayaran', 'aktif', 'selesai', 'dibatalkan', 'ditolak') DEFAULT 'menunggu_konfirmasi'");
                } catch (\Exception $e2) {
                    // Log or ignore if it truly exists
                }
            }
        }
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
