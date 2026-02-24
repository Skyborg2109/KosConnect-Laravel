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
        if (Schema::hasTable('notifikasi') && !Schema::hasColumn('notifikasi', 'link')) {
            Schema::table('notifikasi', function (Blueprint $table) {
                $table->string('link')->nullable()->after('pesan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('notifikasi') && Schema::hasColumn('notifikasi', 'link')) {
            Schema::table('notifikasi', function (Blueprint $table) {
                $table->dropColumn('link');
            });
        }
    }
};
