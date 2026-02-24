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
        Schema::table('data_user', function (Blueprint $table) {
            // Cek apakah kolom nomor_telepon belum ada
            if (!Schema::hasColumn('data_user', 'nomor_telepon')) {
                $table->string('nomor_telepon', 15)->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_user', function (Blueprint $table) {
            // Hapus kolom nomor_telepon jika ada
            if (Schema::hasColumn('data_user', 'nomor_telepon')) {
                $table->dropColumn('nomor_telepon');
            }
        });
    }
};
