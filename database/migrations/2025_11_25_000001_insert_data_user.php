<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert admin user
        DB::table('data_user')->updateOrInsert(
            ['email' => 'admin@website.com'],
            [
                'nama_user' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Insert penyewa users
        DB::table('data_user')->updateOrInsert(
            ['email' => 'penyewa1@website.com'],
            [
                'nama_user' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role' => 'penyewa',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('data_user')->updateOrInsert(
            ['email' => 'penyewa2@website.com'],
            [
                'nama_user' => 'Siti Nurhaliza',
                'password' => Hash::make('password123'),
                'role' => 'penyewa',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Insert pemilik users
        DB::table('data_user')->updateOrInsert(
            ['email' => 'pemilik1@website.com'],
            [
                'nama_user' => 'Ahmad Wijaya',
                'password' => Hash::make('password123'),
                'role' => 'pemilik',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('data_user')->updateOrInsert(
            ['email' => 'pemilik2@website.com'],
            [
                'nama_user' => 'Dewi Lestari',
                'password' => Hash::make('password123'),
                'role' => 'pemilik',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('data_user')->whereIn('email', [
            'admin@website.com',
            'penyewa1@website.com',
            'penyewa2@website.com',
            'pemilik1@website.com',
            'pemilik2@website.com',
        ])->delete();
    }
};
