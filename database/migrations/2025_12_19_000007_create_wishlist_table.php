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
        if (!Schema::hasTable('wishlist')) {
            Schema::create('wishlist', function (Blueprint $table) {
                $table->id();
                $table->foreignId('penyewa_id')->constrained('data_user')->onDelete('cascade');
                $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade');
                $table->timestamps();
                
                // Prevent duplicate wishlist entries
                $table->unique(['penyewa_id', 'kos_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlist');
    }
};
