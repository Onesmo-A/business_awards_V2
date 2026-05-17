<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nominees', function (Blueprint $table) {
            if (!Schema::hasColumn('nominees', 'year')) {
                // Tunaweka default 2025 kwa data zilizopo
                $table->integer('year')->default(2025)->after('category_id')->index();
            }
        });
    }

    public function down()
    {
        Schema::table('nominees', function (Blueprint $table) {
            if (Schema::hasColumn('nominees', 'year')) {
                $table->dropColumn('year');
            }
        });
    }
};