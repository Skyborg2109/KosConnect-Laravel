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
        if (!Schema::hasTable('review')) {
            Schema::create('review', function (Blueprint $table) {
                $table->id();
                $table->foreignId('penyewa_id')->constrained('data_user')->onDelete('cascade');
                $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade');
                $table->integer('rating');
                $table->text('komentar')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};
