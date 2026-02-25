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
        if (!Schema::hasTable('keluhan')) {
            Schema::create('keluhan', function (Blueprint $table) {
                $table->id();
                $table->foreignId('penyewa_id')->constrained('data_user')->onDelete('cascade');
                $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade');
                $table->string('judul');
                $table->text('deskripsi');
                $table->string('kategori')->nullable();
                $table->enum('status', ['pending', 'diproses', 'selesai'])->default('pending');
                $table->timestamp('tanggal_selesai')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhan');
    }
};
