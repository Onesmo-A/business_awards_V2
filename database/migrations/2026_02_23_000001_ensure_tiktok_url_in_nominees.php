<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nominees', function (Blueprint $table) {
            if (!Schema::hasColumn('nominees', 'tiktok_url')) {
                $table->string('tiktok_url')->nullable()->after('instagram_url');
            }
        });
    }

    public function down()
    {
        Schema::table('nominees', function (Blueprint $table) {
            if (Schema::hasColumn('nominees', 'tiktok_url')) {
                $table->dropColumn('tiktok_url');
            }
        });
    }
};