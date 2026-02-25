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
            if (!Schema::hasColumn('data_user', 'twitter_id')) {
                Schema::table('data_user', function (Blueprint $table) {
                    // Check if facebook_id exists to use it for 'after' positioning
                    if (Schema::hasColumn('data_user', 'facebook_id')) {
                        $table->string('twitter_id')->nullable()->after('facebook_id');
                    } else {
                        // If facebook_id is missing (depends on migration order), just add at end or after id
                        $table->string('twitter_id')->nullable()->after('id');
                    }
                });
            }
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
