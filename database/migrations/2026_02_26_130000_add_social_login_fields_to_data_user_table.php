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
    // ❗ Pastikan tabelnya ada dulu
    if (!Schema::hasTable('data_user')) {
        return;
    }

    // Ensure email exists
    if (!Schema::hasColumn('data_user', 'email')) {
        Schema::table('data_user', function (Blueprint $table) {
            $table->string('email')->nullable()->unique()->after('nama_user');
        });
    }

    if (!Schema::hasColumn('data_user', 'nomor_telepon')) {
        Schema::table('data_user', function (Blueprint $table) {
            $table->string('nomor_telepon')->nullable()->after('email');
        });
    }

    if (!Schema::hasColumn('data_user', 'google_id')) {
        Schema::table('data_user', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('password');
        });
    }

    if (!Schema::hasColumn('data_user', 'facebook_id')) {
        Schema::table('data_user', function (Blueprint $table) {
            $table->string('facebook_id')->nullable()->after('google_id');
        });
    }

    if (!Schema::hasColumn('data_user', 'alamat')) {
        Schema::table('data_user', function (Blueprint $table) {
            $table->text('alamat')->nullable();
        });
    }

    if (!Schema::hasColumn('data_user', 'tanggal_lahir')) {
        Schema::table('data_user', function (Blueprint $table) {
            $table->date('tanggal_lahir')->nullable();
        });
    }

    if (!Schema::hasColumn('data_user', 'jenis_kelamin')) {
        Schema::table('data_user', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable();
        });
    }

    if (!Schema::hasColumn('data_user', 'foto_profil')) {
        Schema::table('data_user', function (Blueprint $table) {
            $table->string('foto_profil')->nullable();
        });
    }

    if (!Schema::hasColumn('data_user', 'avatar')) {
        Schema::table('data_user', function (Blueprint $table) {
            $table->string('avatar')->nullable();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_user', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'facebook_id', 'avatar']);
        });
    }
};
