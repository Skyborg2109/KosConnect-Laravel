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
        Schema::table('kos', function (Blueprint $table) {
            if (!Schema::hasColumn('kos', 'jenis_kos')) {
                $table->enum('jenis_kos', ['campuran', 'putra', 'putri'])->default('campuran')->after('nama_kos');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kos', function (Blueprint $table) {
            $table->dropColumn('jenis_kos');
        });
    }
};
