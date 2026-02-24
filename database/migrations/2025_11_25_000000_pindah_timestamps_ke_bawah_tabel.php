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
            // Drop existing timestamps
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });

        Schema::table('data_user', function (Blueprint $table) {
            // Re-add timestamps at the bottom
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_user', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });

        Schema::table('data_user', function (Blueprint $table) {
            $table->timestamps();
        });
    }
};
