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
        Schema::create('kos_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kos_id');
            $table->string('image_url');
            $table->integer('order')->default(0);
            $table->timestamps();

            // Foreign key constraint (assuming 'kos' table exists and uses 'id')
            $table->foreign('kos_id')->references('id')->on('kos')->onDelete('cascade');
        });

        Schema::create('kamar_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kamar_id');
            $table->string('image_url');
            $table->integer('order')->default(0);
            $table->timestamps();

            // Foreign key constraint (assuming 'kamar' table exists and uses 'id')
            $table->foreign('kamar_id')->references('id')->on('kamar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar_images');
        Schema::dropIfExists('kos_images');
    }
};
