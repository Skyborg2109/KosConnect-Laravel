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
            if (!Schema::hasColumn('data_user', 'nama_user')) {
                $table->string('nama_user'); 
            }
        });
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
