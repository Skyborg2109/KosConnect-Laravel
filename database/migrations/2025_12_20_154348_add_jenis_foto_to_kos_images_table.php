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
        Schema::table('kos_images', function (Blueprint $table) {
            // Adding jenis_foto column after kos_id
            $table->enum('jenis_foto', ['bangunan', 'fasilitas', 'kamar', 'kamar_mandi', 'lainnya', 'utama'])->default('lainnya')->after('kos_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kos_images', function (Blueprint $table) {
            $table->dropColumn('jenis_foto');
        });
    }
};
