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
            if (!Schema::hasColumn('season_awards', 'can_show_winners')) {
                $table->boolean('can_show_winners')->default(false)->after('cover_image_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('season_awards', function (Blueprint $table) {
            $table->dropColumn('can_show_winners');
        });
    }
};