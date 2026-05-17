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
        Schema::table('season_awards', function (Blueprint $table) {
            if (!Schema::hasColumn('season_awards', 'cover_image_path')) {
                $table->string('cover_image_path')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('season_awards', function (Blueprint $table) {
            $table->dropColumn('cover_image_path');
        });
    }
};