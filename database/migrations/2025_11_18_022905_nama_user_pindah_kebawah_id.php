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
        // Skip this migration if nama_user column already exists
        if (Schema::hasColumn('data_user', 'nama_user')) {
            return;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_user', function (Blueprint $table) {
            if (Schema::hasColumn('data_user', 'nama_user')) {
                $table->dropColumn('nama_user');
            }
        });
    }
};
