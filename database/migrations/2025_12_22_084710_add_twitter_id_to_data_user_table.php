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
        if (Schema::hasTable('data_user')) {
            Schema::table('data_user', function (Blueprint $table) {
                if (!Schema::hasColumn('data_user', 'twitter_id')) {
                    $table->string('twitter_id')->nullable()->after('facebook_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_user', function (Blueprint $table) {
            $table->dropColumn('twitter_id');
        });
    }
};
