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
        if (!Schema::hasTable('kos')) {
            Schema::create('kos', function (Blueprint $table) {
                $table->id();
                $table->string('nama_kos');
                $table->foreignId('pemilik_id')->constrained('data_user')->onDelete('cascade');
                $table->text('alamat');
                $table->string('kota');
                $table->string('provinsi');
                $table->decimal('harga_dasar', 10, 2);
                $table->text('deskripsi')->nullable();
                $table->json('fasilitas')->nullable();
                $table->json('peraturan')->nullable();
                $table->string('gambar')->nullable();
                $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kos');
    }
};
