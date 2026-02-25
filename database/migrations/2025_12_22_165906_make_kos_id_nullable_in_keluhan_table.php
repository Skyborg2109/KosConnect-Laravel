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
        Schema::table('keluhan', function (Blueprint $table) {
            if (Schema::hasColumn('keluhan', 'kos_id')) {
                $table->unsignedBigInteger('kos_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->unsignedBigInteger('kos_id')->nullable(false)->change();
        });
    }
};
