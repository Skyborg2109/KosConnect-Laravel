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
            $table->string('prioritas')->default('sedang')->after('status');
            $table->string('bukti')->nullable()->after('prioritas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->dropColumn(['prioritas', 'bukti']);
        });
    }
};
