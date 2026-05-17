<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'year')) {
                // Tunaweka default 2025 kwa kategoria zilizopo
                $table->integer('year')->default(2025)->after('id')->index();
            }
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'year')) {
                $table->dropColumn('year');
            }
        });
    }
};
