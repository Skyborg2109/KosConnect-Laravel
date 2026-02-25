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
        if (Schema::hasTable('keluhan')) {
            Schema::table('keluhan', function (Blueprint $table) {
                if (!Schema::hasColumn('keluhan', 'prioritas')) {
                    $table->string('prioritas')->default('sedang')->after('status');
                }
                if (!Schema::hasColumn('keluhan', 'bukti')) {
                    $table->string('bukti')->nullable()->after('prioritas');
                }
            });
        }
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
