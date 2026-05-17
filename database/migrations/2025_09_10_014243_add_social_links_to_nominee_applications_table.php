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
        Schema::table('nominee_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('nominee_applications', 'facebook_url')) {
                $table->string('facebook_url')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('nominee_applications', 'instagram_url')) {
                $table->string('instagram_url')->nullable()->after('facebook_url');
            }
            if (!Schema::hasColumn('nominee_applications', 'tiktok_url')) {
                $table->string('tiktok_url')->nullable()->after('instagram_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nominee_applications', function (Blueprint $table) {
            $columns = ['facebook_url', 'instagram_url', 'tiktok_url'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('nominee_applications', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
